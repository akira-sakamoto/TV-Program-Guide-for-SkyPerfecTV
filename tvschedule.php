<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
  <meta charset="UTF-8">
  <title>CS 番組表</title>

<?php
  if (count($_POST) > 0) {
    $channel = $_POST["channel"];
    $year    = $_POST["year"];
    $month   = $_POST["month"];
    $day     = $_POST["day"];

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
        $url = sprintf("http://www.tv-asahi.co.jp/channel/contents/timetable/html/bangumi/%2d%02d_%d.html", substr($year,2), $month, $day);
        break;

      case "discovery":
        $chname = "ディスカバリーチャンネル";
        $url = sprintf("http://japan.discovery.com/schedules/index.php?date=%4d-%02d-%d&ht=1", $year, $month, $day);
        break;

      case "tbschannel":
        $chname = "TBSチャンネル";
        $url = sprintf("http://www.tbs.co.jp/tbs-ch/schedules/weekly/%4d%02d%02d.html", $year, $month, $day);
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

function StarChannel($yy, $mm, $id) {
  return sprintf("http://www.star-ch.jp/pdf/j/download_pub.php?date=%2d%02d&channel_id=%1d", substr($yy, 2), $mm, $id);
}
?>
</head>
<body>
  <form method="post" action="tvschedule.php">
    <table>
      <tr>
        <td align="right">チャネル:</td>
        <td>
          <select id="channel" name="channel">
            <option value="homedrama">ホームドラマチャンネル</option>
            <option value="superdrama">スーパードラマチャンネル</option>
            <option value="axn">AXN</option>
            <option value="axnmistery">AXNミステリー</option>
            <option value="movieplus">Movie Plus</option>
            <option value="star1">スター・チャンネル１</option>
            <option value="star2">スター・チャンネル２</option>
            <option value="star3">スター・チャンネル３</option>
            <option value="tvasahi">テレビ朝日チャンネル</option>
            <option value="discovery">ディスカバリーチャンネル</option>
            <option value="tbschannel">TBSチャンネル</option>
          </select>
        </td>
      </tr>
      <tr>
        <td align="right">年:</td>
        <td><input type="text" name="year" size="10" maxlength="4" required></td>
      </tr>
      <tr>
        <td align="right">月:</td>
        <td><input type="text" name="month" size="5" maxlength="2" required></td>
      </tr>
      <tr>
        <td align="right">日:</td>
        <td><input type="text" name="day" size="5" maxlength="2" required></td>
      </tr>
      <tr>
        <td colspan="2" align="center">
          <input type="submit" value="実行">
        </td>
      </tr>
    </table>
  </form>
</body>
</html>

