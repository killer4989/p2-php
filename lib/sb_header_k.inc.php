<?php
/**
 * rep2 - サブジェクト - 携帯ヘッダ表示
 * for subject.php
 */

//===============================================================
// HTML表示用変数
//===============================================================
$newtime = date("gis");
$norefresh_q = "&amp;norefresh=1";

// {{{ ページタイトル部分URL設定

$p2_subject_url = "{$_conf['subject_php']}?host={$aThreadList->host}&amp;bbs={$aThreadList->bbs}{$_conf['k_at_a']}";

// 通常 板
if (!$aThreadList->spmode) {
    // 検索語あり
    if ((isset($GLOBALS['word']) && strlen($GLOBALS['word']) > 0) || !empty($GLOBALS['wakati_words'])) {
        $ptitle_url = $p2_subject_url;

    // 2ch系
    } elseif (P2HostMgr::isHost2chs($aThreadList->host)) {
        if (P2HostMgr::isHostBbsPink($aThreadList->host)) {
            //$ptitle_url = "http://{$aThreadList->host}/{$aThreadList->bbs}/i/";
            $ptitle_url = "http://speedo.ula.cc/test/p.so/{$aThreadList->host}/{$aThreadList->bbs}/";
        } else {
            $ptitle_url = "http://c.2ch.net/test/-/{$aThreadList->bbs}/i";
        }

    // その他
    } else {
        $ptitle_url = "http://{$aThreadList->host}/{$aThreadList->bbs}/";
        // 特別なパターン index2.html
        // match登録よりheadなげて聞いたほうがよさそうだが、ワンレスポンス増えるのが困る
        if (!strcasecmp($aThreadList->host, 'livesoccer.net')) {
            $ptitle_url .= 'index2.html';
        }
    }

// あぼーん or 倉庫
} elseif ($aThreadList->spmode == 'taborn' || $aThreadList->spmode == 'soko') {
    $ptitle_url = $p2_subject_url;

// 書き込み履歴
} elseif ($aThreadList->spmode == 'res_hist') {
    $ptitle_url = "./read_res_hist.php{$_conf['k_at_q']}#footer";
}

// }}}
// {{{ ページタイトル部分HTML設定

if ($aThreadList->spmode == 'fav' && $_conf['expack.misc.multi_favs']) {
    $ptitle_hd = FavSetManager::getFavSetPageTitleHt('m_favlist_set', $aThreadList->ptitle);
} else {
    $ptitle_hd = p2h($aThreadList->ptitle);
}

if ($aThreadList->spmode == 'taborn') {
    $ptitle_ht = <<<EOP
<a href="{$ptitle_url}"><b>{$aThreadList->itaj_hd}</b></a>（ｱﾎﾞﾝ中）
EOP;
} elseif ($aThreadList->spmode == 'soko') {
    $ptitle_ht = <<<EOP
<a href="{$ptitle_url}"><b>{$aThreadList->itaj_hd}</b></a>（dat倉庫）
EOP;
} elseif (!empty($ptitle_url)) {
    $ptitle_ht = <<<EOP
<a href="{$ptitle_url}" class="nobutton"><b>{$ptitle_hd}</b></a>
EOP;
} else {
    $ptitle_ht = <<<EOP
<b>{$ptitle_hd}</b>
EOP;
}

// }}}
// フォーム ==================================================
$sb_form_hidden_ht = <<<EOP
<input type="hidden" name="bbs" value="{$aThreadList->bbs}">
<input type="hidden" name="host" value="{$aThreadList->host}">
<input type="hidden" name="spmode" value="{$aThreadList->spmode}">
{$_conf['detect_hint_input_ht']}{$_conf['k_input_ht']}{$_conf['m_favita_set_input_ht']}
EOP;

// フィルタ検索 ==================================================

$hd['word'] = p2h($word);

$filter_form_ht = '';
$hit_ht = '';

if (!$spmode_without_palace_or_favita) {
    if (array_key_exists('method', $sb_filter) && $sb_filter['method'] == 'or') {
        $hd['method_checked_at'] = ' checked';
    } else {
        $hd['method_checked_at'] = '';
    }

    $filter_form_ht = <<<EOP
<form method="GET" action="{$_conf['subject_php']}" accept-charset="{$_conf['accept_charset']}">
{$sb_form_hidden_ht}<input type="text" id="sb_filter_word" name="word" value="{$hd['word']}" size="15">
<input type="checkbox" id="sb_filter_method" name="method" value="or"{$hd['method_checked_at']}><label for="sb_filter_method">OR</label>
<input type="submit" name="submit_kensaku" value="検索">
</form>\n
EOP;
}

// 検索結果
if ($GLOBALS['sb_mikke_num']) {
    $hit_ht = "<div>&quot;{$word}&quot; {$GLOBALS['sb_mikke_num']}hit!</div>";
}

//=================================================
//ヘッダプリント
//=================================================
P2Util::header_nocache();
echo $_conf['doctype'];
echo <<<EOP
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
<meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
{$_conf['extra_headers_ht']}
<title>{$ptitle_hd}</title>
</head>
<body{$_conf['k_colors']}>
EOP;

P2Util::printInfoHtml();

include P2_LIB_DIR . '/sb_toolbar_k.inc.php';

echo <<<EOP
<form method="get" action="{$_conf['read_new_k_php']}">
{$sb_form_hidden_ht}<input type="hidden" name="nt" value="1">{$shinchaku_norefresh_ht}
未読数が<input type="text" name="unum_limit" value="100" size="4" maxlength="4" istyle="4" format="4N" mode="numeric">未満の
<input type="submit" value="新まとめ">
</form>\n
EOP;

echo $filter_form_ht;
echo $hit_ht;
echo '<hr>';

/*
 * Local Variables:
 * mode: php
 * coding: cp932
 * tab-width: 4
 * c-basic-offset: 4
 * indent-tabs-mode: nil
 * End:
 */
// vim: set syn=php fenc=cp932 ai et ts=4 sw=4 sts=4 fdm=marker:
