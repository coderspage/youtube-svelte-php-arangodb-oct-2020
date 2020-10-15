<?php
header('Access-Control-Allow-Origin: *');
use ArangoDBClient\ConnectException as ArangoConnectException;
use ArangoDBClient\Exception as ArangoException;
use ArangoDBClient\Statement as ArangoStatement;
require_once(__DIR__.'/arangodb.php');

if( isset($_POST['name']) ){
  $user['name'] = $_POST['name'];
}
if( isset($_POST['lastName']) ){
  $user['lastName'] = $_POST['lastName'];
}


try{
  $stmt = new ArangoStatement(
    $db,
    [ 
      'query'=>'UPDATE @key WITH @user IN users',
      'bindVars' => [
        'key' => $_POST['_key'],
        'user' => $user
      ]
    ]
  );
  $cursor = $stmt->execute();
  $data = $cursor->getAll();
  // header('Content-Type: application/json');
  echo json_encode($data);
}catch(Exception $ex){
  echo $ex;
}

