<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta charset="UTF-8">
  <title>CS 番組表</title>
  <script type="text/javascript" src="jkl-calendar.js" language="JavaScript" charset="utf-8"></script>
<?php
date_default_timezone_set('Asia/Tokyo');

$myapp = "tvschedule.php";

if (count($_POST) > 0) {
  $channel = $_POST["channel"];
  $year    = $_POST["year"];

  if (strlen($year) > 4) {
    $dt = split("/", $year);
    $year  = $dt[0];
    $month = $dt[1];
    $day   = $dt[2];
  }
  else { 
    $month   = $_POST["month"];
    $day     = $_POST["day"];
  }

  switch ($channel) {
    case "homedrama":
      $chname = "ホームドラマチャンネル";
      $url = sprintf("http://www.homedrama-ch.com/hdc/timetable?action=viewDay2&year=%4d&month=%d&day=%d", $year, $month, $day);
      break;

    case "superdrama":
      $chname = "スーパードラマチャンネル";
      $url = sprintf("http://www.superdramatv.com/program/next.html?date=%4d%02d%02d", $year, $month, $day);
      break;

    case "axn":
      $chname = "AXN";
      $url = sprintf("http://axn.co.jp/timetable/daily/%02d%02d.html", $month, $day);
      break;

    case "axnmistery":
      $chname = "AXNミステリー";
      $url = sprintf("http://mystery.co.jp/timetable/daily/%02d%02d.html", $month, $day);
      break;

    case "movieplus":
      $chname = "Movie Plus";
      $url = sprintf("http://www.movieplus.jp/timetable/index.php?year=%4d&month=%d&day=%d", $year, $month, $day);
      break;

    case "star1":
      $chname = "スター・チャンネル1 (PDF)";
      $url = StarChannel($year, $month, 1);
      break;

    case "star2":
      $chname = "スター・チャンネル2 (PDF)";
      $url = StarChannel($year, $month, 2);
      break;

    case "star3":
      $chname = "スター・チャンネル3 (PDF)";
      $url = StarChannel($year, $month, 3);
      break;

    case "tvasahi":
      $chname = "TV朝日チャンネル";
      $url = sprintf("http://www.tv-asahi.co.jp/channel/contents/timetable/html/bangumi/%2d%02d_%d.html", substr($year,2), $month, NumWeek($year, $month, $day));
      break;

    case "discovery":
      $chname = "ディスカバリーチャンネル";
      $url = sprintf("http://japan.discovery.com/schedules/index.php?date=%4d-%02d-%d&ht=1", $year, $month, $day);
      break;

    case "family":
      $chname = "ファミリー劇場";
      $url = sprintf("http://www.fami-geki.com/timetable/daily.php?date=%4d%02d%02d", $year, $month, $day);
      break;

   case "tbschannel":
      $chname = "TBSチャンネル";
      $url = sprintf("http://www.tbs.co.jp/tbs-ch/schedules/weekly/%4d%02d%02d.html", $year, $month, $day);
      break;

    case "jidaigeki":
      $chname = "時代劇専門チャンネル";
      $url = sprintf("http://www.jidaigeki.com/timetable" . NihonEiga($year, $month, $day));
      break;

    case "nihoneiga":
      $chname = "日本映画専門チャンネル";
      $url = "http://www.nihon-eiga.com/timetable" . NihonEiga($year, $month, $day);
      break;

    default:
      print("unknown channel<br /n>");
      break;
  }

  if ($url <> "") {
    print("<table border=\"1\"><tr><td>");
    print("チャネル: $chname<br /n>");
    print("日付: $year/$month/$day<br /n>");
    print("<a href=\"$url\" target=\"_blank\">$url</a>");
    print("</td></tr></table>");
    print("<p></p>");
  }
}
else {
  $year = date("Y");
}


function StarChannel($yy, $mm, $id) {
  return sprintf("http://www.star-ch.jp/pdf/j/download_pub.php?date=%2d%02d&channel_id=%1d", substr($yy, 2), $mm, $id);
}

// Jidaigeki & NihonEiga
function NihonEiga($yy, $mm, $dd) {
  $today = getdate();
  $thisweek = NumWeek($today['year'], $today['mon'], $today['mday']);
  $tgtweek  = NumWeek($yy, $mm, $dd);
  if ($thisweek == $tgtweek) {
     return "/index.html";
  }
  else {
     return sprintf("/%4d%02d%02d.html", $yy, $mm, $tgtweek);
  }
}

function NumWeek($yy, $mm, $dd) {
//  $ti = mktime(0, 0, 0, $mm, 1, $yy);
//  $wd = (int)((date("w", $ti) + 6) / 7);
//  return (int)((($dd + $wd - 1) / 7) + 1);
  $t1 = date("W", mktime(0, 0, 0, $mm, 1, $yy));
  $tt = date("W", mktime(0, 0, 0, $mm, $dd, $yy));
  return $tt - $t1 + 1;
}

?>
</head>
<body>
  <script>
<!--
  var cal1 = new JKL.Calendar("calid", "formid", "year");
//-->
  </script>
  <form id="formid" method="post" action=<?php $myapp ?>>
    <table>
      <tr>
        <td align="right">チャネル:</td>
        <td colspan="2">
          <select id="channel" name="channel">
            <option value="movieplus">312: Movie Plus</option>
            <option value="star1">315: スター・チャンネル１</option>
            <option value="star2">316: スター・チャンネル２</option>
            <option value="star3">317: スター・チャンネル３</option>
            <option value="superdrama">360: スーパードラマチャンネル</option>
            <option value="family">361: ファミリー劇場</option>
            <option value="homedrama">362: ホームドラマチャンネル</option>
            <option value="tbschannel">363: TBSチャンネル</option>
            <option value="nihoneiga">707: 日本映画専門チャンネル</option>
            <option value="tvasahi">717: テレビ朝日チャンネル</option>
            <option value="jidaigeki">718: 時代劇専門チャンネル</option>
            <option value="discovery">321: ディスカバリーチャンネル</option>
            <option value="axn">725: AXN</option>
            <option value="axnmistery">728: AXNミステリー</option>
          </select>
        </td>
      </tr>
      <tr>
        <td align="right">年:</td>
        <td>
          <input type="text" name="year" size="12" maxlength="10" 
          <?php print("value=\"$year\""); ?>
          required>
        </td>
        <td align="right">
          <img src="3525_32.png" onClick="cal1.write();">
          <div id="calid"></div>
        </td>
      </tr>

      <tr>
        <td align="right">月:</td>
        <td colspan="2"><input type="text" name="month" size="5" maxlength="2"></td>
      </tr>
      <tr>
        <td align="right">日:</td>
        <td colspan="2"><input type="text" name="day" size="5" maxlength="2"></td>
      </tr>
      <tr>
        <td colspan="3" align="center">
          <input type="submit" value="実行">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

