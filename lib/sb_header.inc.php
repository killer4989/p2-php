<?php
/**
 * rep2 - �T�u�W�F�N�g - �w�b�_�\��
 * for subject.php
 */

//===================================================================
// �ϐ�
//===================================================================
$newtime = date('gis');
$reloaded_time = date('m/d G:i:s'); //�X�V����
$shinchaku_attayo_json = json_encode($shinchaku_attayo);
$threads_count_json = json_encode($aThreadList->num);
$JSTYLE = JStyle::singleton();

// �X�����ځ[��`�F�b�N�A�q�� =============================================
$taborn_check_ht = '';
if (($aThreadList->spmode == 'taborn' || $aThreadList->spmode == 'soko') && $aThreadList->threads) {
    $offline_num = $aThreadList->num - $online_num;
    $taborn_check_ht = <<<EOP
    <form class="check" method="POST" action="{$_SERVER['SCRIPT_NAME']}" target="_self">\n
EOP;
    if ($offline_num > 0) {
        if ($aThreadList->spmode == 'taborn') {
            $taborn_check_ht .= <<<EOP
<p>{$aThreadList->num}�����A{$offline_num}���̃X���b�h�����ɔT�[�o�̃X���b�h�ꗗ����O��Ă���悤�ł��i�����Ń`�F�b�N�����܂��j</p>\n
EOP;
        }
        /*
        elseif ($aThreadList->spmode == 'soko') {
            $taborn_check_ht .= <<<EOP
<p>{$aThreadList->num}����dat�����X���b�h���ۊǂ���Ă��܂��B</p>\n
EOP;
        }*/
    }
}

//===============================================================
// HTML�\���p�ϐ� for �c�[���o�[(sb_toolbar.inc.php)
//===============================================================

$norefresh_q = '&amp;norefresh=true';

// �y�[�W�^�C�g������URL�ݒ� ====================================
// �ʏ� ��
if (!$aThreadList->spmode) {
    $ptitle_url = "http://{$aThreadList->host}/{$aThreadList->bbs}/";
    // match�o�^���head�Ȃ��ĕ������ق����悳���������A�������X�|���X������̂�����
    if (!strcasecmp($aThreadList->host, 'livesoccer.net')) {
        $ptitle_url .= 'index2.html';
    }

// ���ځ[�� or �q��
} elseif ($aThreadList->spmode == 'taborn' || $aThreadList->spmode == 'soko') {
    $ptitle_url = "{$_conf['subject_php']}?host={$aThreadList->host}&amp;bbs={$aThreadList->bbs}";

// �������ݗ���
} elseif ($aThreadList->spmode == 'res_hist') {
    $ptitle_url = './read_res_hist.php#footer';
}

// �y�[�W�^�C�g������HTML�ݒ� ====================================
if ($aThreadList->spmode == 'fav' && $_conf['expack.misc.multi_favs']) {
    $ptitle_hd = FavSetManager::getFavSetPageTitleHt('m_favlist_set', $aThreadList->ptitle);
} else {
    $ptitle_hd = p2h($aThreadList->ptitle);
}
$ptitle_json = p2_json_encode($aThreadList->ptitle);

if ($aThreadList->spmode == 'taborn') {
    $ptitle_ht = <<<EOP
<span class="itatitle"><a class="aitatitle" href="{$ptitle_url}" target="_self"><b>{$aThreadList->itaj_hd}</b></a>�i���ځ[�񒆁j</span>
EOP;
} elseif ($aThreadList->spmode == 'soko') {
    $ptitle_ht = <<<EOP
<span class="itatitle"><a class="aitatitle" href="{$ptitle_url}" target="_self"><b>{$aThreadList->itaj_hd}</b></a>�idat�q�Ɂj</span>
EOP;
} elseif (!empty($ptitle_url)) {
    $ptitle_ht = <<<EOP
<span class="itatitle"><a class="aitatitle" href="{$ptitle_url}"><b>{$ptitle_hd}</b></a></span>
EOP;
} else {
    $ptitle_ht = <<<EOP
<span class="itatitle"><b>{$ptitle_hd}</b></span>
EOP;
}

// �r���[�����ݒ� ==============================================
$edit_ht = '';
if ($aThreadList->spmode) { // �X�y�V�������[�h��
    if ($aThreadList->spmode == 'fav' || $aThreadList->spmode == 'palace'){ // ���C�ɃX�� or �a���Ȃ�
        if ($sb_view == 'edit'){
            $edit_ht="<a class=\"narabi\" href=\"{$_conf['subject_php']}?spmode={$aThreadList->spmode}{$norefresh_q}\" target=\"_self\">����</a>";
        } else {
            $edit_ht="<a class=\"narabi\" href=\"{$_conf['subject_php']}?spmode={$aThreadList->spmode}&amp;sb_view=edit{$norefresh_q}\" target=\"_self\">����</a>";

        }
    }
}

// �t�H�[��hidden ==================================================
$sb_form_hidden_ht = <<<EOP
    <input type="hidden" name="bbs" value="{$aThreadList->bbs}">
    <input type="hidden" name="host" value="{$aThreadList->host}">
    <input type="hidden" name="spmode" value="{$aThreadList->spmode}">
    {$_conf['detect_hint_input_ht']}{$_conf['k_input_ht']}
EOP;

//�\������ ==================================================
if (!$aThreadList->spmode || $aThreadList->spmode == 'merge_favita') {

    $vncheck = array('100', '150', '200', '250', '300', '400', '500', 'all');
    $vncheck = array_combine($vncheck, array_fill(0, count($vncheck), ''));
    if (array_key_exists($p2_setting['viewnum'], $vncheck)) {
        $vncheck[$p2_setting['viewnum']] = ' selected';
    } else {
        $vncheck['150'] = ' selected';
    }

    $sb_disp_num_ht =<<<EOP
<select name="viewnum">
    <option value="100"{$vncheck['100']}>100��</option>
    <option value="150"{$vncheck['150']}>150��</option>
    <option value="200"{$vncheck['200']}>200��</option>
    <option value="250"{$vncheck['250']}>250��</option>
    <option value="300"{$vncheck['300']}>300��</option>
    <option value="400"{$vncheck['400']}>400��</option>
    <option value="500"{$vncheck['500']}>500��</option>
    <option value="all"{$vncheck['all']}>�S��</option>
</select>
EOP;
} else {
    $sb_disp_num_ht = '';
}

// �t�B���^���� ==================================================
$selected_method = array('and' => '', 'or' => '', 'just' => '', 'regex' => '', 'similar' => '');
$selected_method[($sb_filter['method'])] = ' selected';
$hd['word'] = p2h(isset($GLOBALS['wakati_word']) ? $GLOBALS['wakati_word'] : $word);
$checked_ht = array('find_cont' => (!empty($_REQUEST['find_cont'])) ? 'checked' : '');

$input_find_cont_ht = <<<EOP
<input type="checkbox" name="find_cont" value="1"{$checked_ht['find_cont']} title="�X���{���������ΏۂɊ܂߂�iDAT�擾�ς݃X���b�h�̂݁j">�{��
EOP;

$filter_form_ht = <<<EOP
        <form class="toolbar" method="GET" action="{$_conf['subject_php']}" accept-charset="{$_conf['accept_charset']}" target="_self">
            {$sb_form_hidden_ht}
            <input type="text" name="word" value="{$hd['word']}" size="16">
            <select name="method">
                <option value="or"{$selected_method['or']}>�����ꂩ</option>
                <option value="and"{$selected_method['and']}>���ׂ�</option>
                <option value="just"{$selected_method['just']}>���̂܂�</option>
                <option value="regex"{$selected_method['regex']}>���K�\��</option>
                <option value="similar"{$selected_method['similar']}>���R��</option>
            </select>
            {$input_find_cont_ht}
            <input type="submit" name="submit_kensaku" value="����">
        </form>
EOP;



// �`�F�b�N�t�H�[�� =====================================
$abornoff_ht = '';
if ($aThreadList->spmode == 'taborn') {
    $abornoff_ht = "<input type=\"submit\" name=\"submit\" value=\"{$abornoff_st}\">";
}
$check_form_ht = '';
if ($taborn_check_ht) {
    $check_form_ht = <<<EOP
<p>�`�F�b�N�������ڂ�
<input type="submit" name="submit" value="{$deletelog_st}">
{$abornoff_ht}</p>
EOP;
}

//===================================================================
// HTML�v�����g
//===================================================================
echo $_conf['doctype'];
echo <<<EOP
<html lang="ja">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=Shift_JIS">
    <meta http-equiv="Content-Style-Type" content="text/css">
    <meta http-equiv="Content-Script-Type" content="text/javascript">
    <meta name="ROBOTS" content="NOINDEX, NOFOLLOW">
    {$_conf['extra_headers_ht']}\n
EOP;

if ($_conf['refresh_time']) {
    $refresh_time_s = $_conf['refresh_time'] * 60;
    $refresh_url = "{$_conf['subject_php']}?host={$aThreadList->host}&amp;bbs={$aThreadList->bbs}&amp;spmode={$aThreadList->spmode}";
    echo <<<EOP
    <meta http-equiv="refresh" content="{$refresh_time_s};URL={$refresh_url}">
EOP;
}

echo <<<EOP
    <title>{$ptitle_hd}</title>
    <base target="read">
    <link rel="stylesheet" type="text/css" href="css/blank.css">
    <link rel="stylesheet" type="text/css" href="css.php?css=style&amp;skin={$skin_en}">
    <link rel="stylesheet" type="text/css" href="css.php?css=subject&amp;skin={$skin_en}">
    <link rel="shortcut icon" type="image/x-icon" href="favicon.ico">
    <script type="text/javascript" src="js/basic.js?{$_conf['p2_version_id']}"></script>
    <script type="text/javascript" src="js/setfavjs.js?{$_conf['p2_version_id']}"></script>
    <script type="text/javascript" src="js/settabornjs.js?{$_conf['p2_version_id']}"></script>
    <script type="text/javascript" src="js/delelog.js?{$_conf['p2_version_id']}"></script>
    <script type="text/javascript" src="js/respopup.js?{$_conf['p2_version_id']}"></script>
    <script type="text/javascript" src="js/motolspopup.js?{$_conf['p2_version_id']}"></script>
    <script type="text/javascript" src="js/jquery-{$_conf['jquery_version']}.min.js"></script>
    <script type="text/javascript">
    //<![CDATA[
    rep2.subject.properties = {
        'shinchaku_ari': {$shinchaku_attayo_json},
        'page_title': {$ptitle_json},
        'threads_count': {$threads_count_json},
        'ttcolor': {$JSTYLE['sb_ttcolor']},
        'ttcolor_v': {$JSTYLE['thre_title_color_v']},
        'pop_size': [{$JSTYLE['info_pop_size']}]
    };
    //]]>
    </script>
    <script type="text/javascript" src="js/subject.js?{$_conf['p2_version_id']}"></script>\n
EOP;

if (!empty($_SESSION['use_narrow_toolbars'])) {
    echo <<<EOP
    <link rel="stylesheet" type="text/css" href="css.php?css=narrow_toolbar&amp;skin={$skin_en}">\n
EOP;
}

echo <<<EOP
</head>
<body>
EOP;

include P2_LIB_DIR . '/sb_toolbar.inc.php';

P2Util::printInfoHtml();

echo <<<EOP
{$taborn_check_ht}{$check_form_ht}
<table class="threadlist" cellspacing="0">\n
EOP;

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
