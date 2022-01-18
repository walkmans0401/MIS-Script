<?php
$servername = "localhost:3306";
$username = "";
$password = "";
$date = date("Y/m/d",strtotime("-1 day"));

$conn = new mysqli($servername, $username, $password);

    if ($conn->connect_error) {
    die("資料庫連接失敗 " . $conn->connect_error);
    }
    echo "資料庫連接成功";
    echo date("Y/m/d",strtotime("-1 day")), "<br>";

mysqli_query($conn , "set names utf8");

if($_GET["export"]=="excel"){

header("Content-Type:   application/vnd.ms-excel; charset=utf-8");
header("Content-Disposition: attachment; filename=差勤".date("Y_m_d").".xls");  //File name extension was wrong
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("Cache-Control: private",false);
}

$sql = "SELECT uid,name,min(`time`) 'ontime',max(`time`) 'downtime'
,concat(
timestampdiff(hour,min(`time`),max(`time`))-(CASE WHEN HOUR(min(`time`))<12 AND HOUR(max(`time`))>13 THEN 1 ELSE 0 END),'hr'
,(timestampdiff(minute,min(`time`),max(`time`))-timestampdiff(hour,min(`time`),max(`time`))*60)
,'min')
as 'time'
,CASE WHEN concat(
timestampdiff(hour,min(`time`),max(`time`))-(CASE WHEN HOUR(min(`time`))<12 AND HOUR(max(`time`))>13 THEN 1 ELSE 0 END),'hr'
,(timestampdiff(minute,min(`time`),max(`time`))-timestampdiff(hour,min(`time`),max(`time`))*60)
,'min')<8 THEN '不足' ELSE '足夠' END as 'workHint'
FROM lifeplus.doorkeeper_records
where DATE_FORMAT(`time`,'%Y/%m/%d')='$date' group by uid,name,DATE_FORMAT(`time`,'%Y/%M/%D')";

$data = mysqli_query( $conn, $sql );

echo '<h2>差勤表單<h2>';
echo '<table border="1"><tr><td> UID </td><td> 姓名 </td><td> 上班時間 </td><td> 下班時間 </td><td> 工時 <td> 時數不足 </tr>';
while($row = mysqli_fetch_array($data, MYSQLI_ASSOC))
{
    echo "<tr><td> {$row['uid']}</td> ".
         "<td>{$row['name']} </td> ".
         "<td>{$row['ontime']} </td> ".
         "<td>{$row['downtime']} </td> ".
         "<td>{$row['time']} </td> ".
         "<td>{$row['workHint']} </td> ".
         "</tr>";
}
    echo '</table>';
mysqli_close($conn);
?>
