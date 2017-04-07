<!DOCTYPE html>
<html>
<head>
<style type="text/css">
  div { position: absolute; top: 0px; right: 0px; left: 0px; bottom: 0px; }
  iframe { width: 100%; height: 100%; border: none; }
  body, html { margin: 0; padding: 0; overflow: hidden; }
</style>
</head>
<body>
<?php

  $server = "http://192.99.236.77:81";   // set your site url here
  include "API.php";

  if (isset($_POST["Login"]))
  {
    $player = $_POST["Player"];
    $password = $_POST["Password"];
    $params = array("Command" => "AccountsPassword", "Player" => $player, "PW" => $password);
    $api = Poker_API($params);
    if ($api -> Result != "Ok") die($api -> Error . "<br/>" . "Click Back Button to retry.");
    if ($api -> Verified != "Yes") die("Password is incorrect. Click Back Button to retry.");
    $params = array("Command" => "AccountsSessionKey", "Player" => $player);
    $api = Poker_API($params);
    if ($api -> Result != "Ok") die($api -> Error . "<br/>" . "Click Back Button to retry.");
    $key = $api -> SessionKey;
    $src = $server . "/?LoginName=" . $player . "&SessionKey=" . $key;
    echo "<div><iframe src='http://192.99.236.78'.'$src'></iframe></div>\r\n</body>\r\n</html>";
    exit;
  }
?>

  <h3>Poker Login</h3>
  <form method="post">
    <table>
      <tr>
        <td>Player Name:</td>
        <td><input type="text" name="Player"></td>
      </tr>
      <tr>
        <td>Password:</td>
        <td><input type="password" name="Password"></td>
      </tr>
      <tr>
        <th colspan="2"><input type="submit" name="Login" value="Login"></th>
      </tr>
    </table>
  </form>

</body>
</html>