<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) 2000-2014 LOCKON CO.,LTD. All Rights Reserved.
 *
 * http://www.lockon.co.jp/
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

require_once CLASS_EX_REALDIR . 'page_extends/admin/LC_Page_Admin_Ex.php';

/**
 * PluginName
 *
 * @package Page
 * @author LOCKON CO.,LTD.
 * @version $Id$
 */
class LC_Page_Plugin_EntryRequiredParams_Config extends LC_Page_Admin_Ex
{

    const PLUGIN_CODE = "EntryRequiredParams";

    /**
     * Page を初期化する.
     *
     * @return void
     */
    function init()
    {
        parent::init();

        $plugin = SC_Plugin_Util_Ex::getPluginByPluginCode(self::PLUGIN_CODE);

        $this->tpl_mainpage = PLUGIN_UPLOAD_REALDIR . basename(__DIR__) . "/data/Smarty/config.tpl";
        $this->tpl_subtitle = $plugin["plugin_name"];
    }

    /**
     * Page のプロセス.
     *
     * @return void
     */
    function process()
    {
        $this->action();
        $this->sendResponse();
    }

    /**
     * Page のアクション.
     *
     * @return void
     */
    function action()
    {
        $plugin = SC_Plugin_Util_Ex::getPluginByPluginCode(self::PLUGIN_CODE);
        //テンプレート設定(ポップアップなどの場合)
        $this->setTemplate($this->tpl_mainpage);

        if ($plugin["enable"] == 2) {
            $this->enable = false;
            return;
        }

        $this->enable = true;

        $objFormParam = new SC_FormParam_Ex();
        $this->lfInitParam($objFormParam);
        $objFormParam->setParam($_POST);
        $objFormParam->convParam();

        $this->arrColumns = $this->getColumns();

        $arrForm = array();
        $mode = $this->getMode();
        switch ($mode) {
            // 登録
            case 'confirm':
                $arrForm = $objFormParam->getHashArray();
                $this->arrErr = $objFormParam->checkError();
                
                // エラーなしの場合にはデータを更新
                if (count($this->arrErr) == 0) {
                    // データ更新
                    $ret = $this->updateData($arrForm);
                    if ($ret) {
                        $this->tpl_onload = "alert('登録が完了しました。');";
                    }
                }
                break;
            default:
                if($plugin['free_field1']) {
                    $arrForm = unserialize($plugin['free_field1']);
                } else {
                    $arrForm = array();
                }
                break;
        }

        $this->arrForm = $arrForm;
    }

    /**
     * パラメーター情報の初期化
     *
     * @param object $objFormParam SC_FormParamインスタンス
     * @return void
     */
    public function lfInitParam(&$objFormParam)
    {
        $arrColumns = $this->getColumns();
        foreach ($arrColumns as $arrColumn) {
            $objFormParam->addParam($arrColumn["field"], $arrColumn["field"]);
        }
    }

    public function getColumns()
    {
        $objQuery = & SC_Query_Ex::getSingletonInstance();
        $arrColumns = $objQuery->getAll("show columns from dtb_customer");
        foreach ($arrColumns as $key => $arrColumn) {
            if ($arrColumn["field"] == "customer_id")
                unset($arrColumns[$key]);
        }
        return $arrColumns;
    }

    function updateData($arrData)
    {
        $objQuery = & SC_Query_Ex::getSingletonInstance();
        return $objQuery->update("dtb_plugin", array("free_field1" => serialize($arrData)), "plugin_code = ?", array(self::PLUGIN_CODE));
    }

}
