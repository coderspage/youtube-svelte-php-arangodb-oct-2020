<?php
header('Access-Control-Allow-Origin: *');
use ArangoDBClient\ConnectException as ArangoConnectException;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\Statement as ArangoStatement;
require_once(__DIR__.'/arangodb.php');

$user['name'] = $_POST['name'];
$user['lastName'] = $_POST['lastName'];

try{
  $stmt = new ArangoStatement(
    $db,
    [ 
      'query'=>'INSERT @user IN users RETURN NEW',
      'bindVars' => [
        'user' => $user
      ]
    ]
  );
  $cursor = $stmt->execute();
  $data = $cursor->getAll();
  header('Content-Type: application/json');
  echo json_encode($data);
}catch(Exception $ex){
  echo $ex;
}

