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

require_once CLASS_REALDIR . 'helper/SC_Helper_Customer.php';

/**
 * CSV関連のヘルパークラス(拡張).
 *
 * LC_Helper_Customer をカスタマイズする場合はこのクラスを編集する.
 *
 * @package Helper
 * @author LOCKON CO.,LTD.
 * @version $Id:SC_Helper_DB_Ex.php 15532 2007-08-31 14:39:46Z nanasess $
 */
class plg_EntryRequiredParams_SC_Helper_Customer extends SC_Helper_Customer
{
   /**
     * 会員・顧客・お届け先共通
     *
     * @param SC_FormParam $objFormParam SC_FormParam インスタンス
     * @param string       $prefix       キー名にprefixを付ける場合に指定
     * @access public
     * @return void
     */
    public function sfCustomerCommonParam(&$objFormParam, $prefix = '')
    {
        $objFormParam->addParam('お名前(姓)', $prefix . 'name01', STEXT_LEN, 'aKV', array('EXIST_CHECK', 'NO_SPTAB', 'SPTAB_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('お名前(名)', $prefix . 'name02', STEXT_LEN, 'aKV', array('EXIST_CHECK', 'NO_SPTAB', 'SPTAB_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('会社名', $prefix . 'company_name', STEXT_LEN, 'aKV', array('MAX_LENGTH_CHECK', 'SPTAB_CHECK'));
        if (FORM_COUNTRY_ENABLE === false) {
            $objFormParam->addParam('お名前(フリガナ・姓)', $prefix . 'kana01', STEXT_LEN, 'CKV', array('EXIST_CHECK', 'NO_SPTAB', 'SPTAB_CHECK', 'MAX_LENGTH_CHECK', 'KANA_CHECK'));
            $objFormParam->addParam('お名前(フリガナ・名)', $prefix . 'kana02', STEXT_LEN, 'CKV', array('EXIST_CHECK', 'NO_SPTAB', 'SPTAB_CHECK', 'MAX_LENGTH_CHECK', 'KANA_CHECK'));
            $objFormParam->addParam('郵便番号1', $prefix . 'zip01', ZIP01_LEN, 'n', array('EXIST_CHECK', 'SPTAB_CHECK', 'NUM_CHECK', 'NUM_COUNT_CHECK'));
            $objFormParam->addParam('郵便番号2', $prefix . 'zip02', ZIP02_LEN, 'n', array('EXIST_CHECK', 'SPTAB_CHECK', 'NUM_CHECK', 'NUM_COUNT_CHECK'));
            $objFormParam->addParam('国', $prefix . 'country_id', INT_LEN, 'n', array('NUM_CHECK'));
            $objFormParam->addParam('都道府県', $prefix . 'pref', INT_LEN, 'n', array('EXIST_CHECK', 'NUM_CHECK'));
        } else {
            $objFormParam->addParam('お名前(フリガナ・姓)', $prefix . 'kana01', STEXT_LEN, 'CKV', array('NO_SPTAB', 'SPTAB_CHECK', 'MAX_LENGTH_CHECK', 'KANA_CHECK'));
            $objFormParam->addParam('お名前(フリガナ・名)', $prefix . 'kana02', STEXT_LEN, 'CKV', array('NO_SPTAB', 'SPTAB_CHECK', 'MAX_LENGTH_CHECK', 'KANA_CHECK'));
            $objFormParam->addParam('郵便番号1', $prefix . 'zip01', ZIP01_LEN, 'n', array('SPTAB_CHECK', 'NUM_CHECK', 'NUM_COUNT_CHECK'));
            $objFormParam->addParam('郵便番号2', $prefix . 'zip02', ZIP02_LEN, 'n', array('SPTAB_CHECK', 'NUM_CHECK', 'NUM_COUNT_CHECK'));
            $objFormParam->addParam('国', $prefix . 'country_id', INT_LEN, 'n', array('EXIST_CHECK', 'NUM_CHECK'));
            $objFormParam->addParam('ZIPCODE', $prefix . 'zipcode', STEXT_LEN, 'n', array('NO_SPTAB', 'SPTAB_CHECK', 'GRAPH_CHECK', 'MAX_LENGTH_CHECK'));
            $objFormParam->addParam('都道府県', $prefix . 'pref', INT_LEN, 'n', array('NUM_CHECK'));
        }
        $objFormParam->addParam('住所1', $prefix . 'addr01', MTEXT_LEN, 'aKV', array('EXIST_CHECK', 'SPTAB_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('住所2', $prefix . 'addr02', MTEXT_LEN, 'aKV', array('EXIST_CHECK', 'SPTAB_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('お電話番号1', $prefix . 'tel01', TEL_ITEM_LEN, 'n', array('EXIST_CHECK', 'SPTAB_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('お電話番号2', $prefix . 'tel02', TEL_ITEM_LEN, 'n', array('EXIST_CHECK', 'SPTAB_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('お電話番号3', $prefix . 'tel03', TEL_ITEM_LEN, 'n', array('EXIST_CHECK', 'SPTAB_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('FAX番号1', $prefix . 'fax01', TEL_ITEM_LEN, 'n', array('SPTAB_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('FAX番号2', $prefix . 'fax02', TEL_ITEM_LEN, 'n', array('SPTAB_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('FAX番号3', $prefix . 'fax03', TEL_ITEM_LEN, 'n', array('SPTAB_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
    }

    /**
     * 会員登録共通
     *
     * @param  SC_FormParam $objFormParam SC_FormParam インスタンス
     * @param  boolean      $isAdmin      true:管理者画面 false:会員向け
     * @param  boolean      $is_mypage    マイページの場合 true
     * @param  string       $prefix       キー名にprefixを付ける場合に指定
     * @return void
     */
    public function sfCustomerRegisterParam(&$objFormParam, $isAdmin = false, $is_mypage = false, $prefix = '')
    {
        $objFormParam->addParam('パスワード', $prefix . 'password', PASSWORD_MAX_LEN, '', array('EXIST_CHECK', 'SPTAB_CHECK', 'GRAPH_CHECK'));
        $objFormParam->addParam('パスワード確認用の質問の答え', $prefix . 'reminder_answer', STEXT_LEN, '', array('EXIST_CHECK', 'SPTAB_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('パスワード確認用の質問', $prefix . 'reminder', STEXT_LEN, 'n', array('EXIST_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('性別', $prefix . 'sex', INT_LEN, 'n', array('EXIST_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('職業', $prefix . 'job', INT_LEN, 'n', array('NUM_CHECK', 'MAX_LENGTH_CHECK'));
        $objFormParam->addParam('年', $prefix . 'year', 4, 'n', array('NUM_CHECK', 'MAX_LENGTH_CHECK'), '', false);
        $objFormParam->addParam('月', $prefix . 'month', 2, 'n', array('NUM_CHECK', 'MAX_LENGTH_CHECK'), '', false);
        $objFormParam->addParam('日', $prefix . 'day', 2, 'n', array('NUM_CHECK', 'MAX_LENGTH_CHECK'), '', false);

        $objFormParam->addParam('メールマガジン', $prefix . 'mailmaga_flg', INT_LEN, 'n', array('EXIST_CHECK', 'NUM_CHECK', 'MAX_LENGTH_CHECK'));

        if (SC_Display_Ex::detectDevice() !== DEVICE_TYPE_MOBILE) {
            $objFormParam->addParam('メールアドレス', $prefix . 'email', null, 'a', array('NO_SPTAB', 'EXIST_CHECK', 'EMAIL_CHECK', 'SPTAB_CHECK', 'EMAIL_CHAR_CHECK'));
            $objFormParam->addParam('パスワード(確認)', $prefix . 'password02', PASSWORD_MAX_LEN, '', array('EXIST_CHECK', 'SPTAB_CHECK', 'GRAPH_CHECK'), '', false);
            if (!$isAdmin) {
                $objFormParam->addParam('メールアドレス(確認)', $prefix . 'email02', null, 'a', array('NO_SPTAB', 'EXIST_CHECK', 'EMAIL_CHECK', 'SPTAB_CHECK', 'EMAIL_CHAR_CHECK'), '', false);
            }
        } else {
            if (!$is_mypage) {
                $objFormParam->addParam('メールアドレス', $prefix . 'email', null, 'a', array('EXIST_CHECK', 'EMAIL_CHECK', 'NO_SPTAB', 'EMAIL_CHAR_CHECK', 'MOBILE_EMAIL_CHECK'));
            }
        }
    }
}
