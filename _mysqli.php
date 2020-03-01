<?php
####----------------------------------------------------------------####
#  _mysqli.php
#  12.02.2019
#  ver: 2.0 
#  rev: 1 - 28.2.2020
#  D'ssConnecTed
#
####----------------------------------------------------------------####
####----------------------  DB Settings  ---------------------------####
    $dbset = array(
        'host' => 'localhost',
        'user' => 'root',
        'pass' => 'vertrigo',
		'database' => 'egeli',
		//'dbprefix' => 'fx-',
		'charset' => 'UTF8',
    );
    $dbget = array(
        'db-error' => 'Database bağlantı hatası: ',
        'error' => 'SQL Error: ',
        'limit' => 50, // Sayfada gösterılecek ıcerık sayısı..
        'count' => 0,
    );  
####----------------------  DB START CONNECT  ----------------------####
    $conn = fsql("connect",$dbset['host'],$dbset['user'],$dbset['pass'], $dbset['database']);
	        fsql("charset",$dbset['charset']);
			if(fsql("errno")){echo $dbget['db-error'] . fsql("cerror");exit();} 
			 
####--------------------  fsql Function START  -----------------------####
	
	function fsql($fn,$s='',$r='0',$f='null',$e='null'){
	    global $dbget,$conn;
	    switch($fn){
        case'query':     $a = mysqli_query($conn,$s);$dbget['count']++;       break;
        case'mquery':    $a = mysqli_multi_query($conn,$s);$dbget['count']++; break;
	    	case'farray':    $a = mysqli_fetch_array($s);          break;
    		case'fassoc':    $a = mysqli_fetch_assoc($s);          break;
	    	case'frow':      $a = mysqli_fetch_row($s);            break;
	    	case'fobject':   $a = mysqli_fetch_object($s);         break;
			  case'numrow':    $a = mysqli_num_rows($s);             break;
	    	case'affrow':    $a = mysqli_affected_rows($s);        break;
	    	case'fcount':    $a = mysqli_field_count($conn);       break;
	    	case'flengths':  $a = mysqli_fetch_lengths($s);        break;
			  case'restring':  $a = mysqli_real_escape_string($conn, $s); break;
	    	case'freeresult':$a = mysqli_free_result($s);          break;
			case'insert':    $a = mysqli_query($conn,"INSERT INTO ".$s." (".$r.") VALUES (".$f.")");$dbget['count']++; break;
			case'insertid':  $a = mysqli_insert_id($conn);         break;
			case'tablelist': $a = mysqli_query($conn,"SELECT * FROM INFORMATION_SCHEMA.COLUMNS WHERE table_name = ".$s." AND table_schema = ".$r."");$dbget['count']++; break;
			case'dblist':    $a = mysqli_query($conn,"SELECT * FROM INFORMATION_SCHEMA.TABLES WHERE table_schema = ".$s."");$dbget['count']++; break;
			case'connect':   return mysqli_connect($s, $r, $f, $e);break;
	    case'charset':   return mysqli_set_charset($conn,$s);  break;
			case'errno':     return mysqli_connect_errno(); break;
			case'cerror':    return mysqli_connect_error(); break;
			case'error':     $a = $dbget['error']. mysqli_error($conn); break;
			case'close':     return mysqli_close($conn);           break;
			case'counter':   $a = $dbget['count'];                 break;
        }
		return $a;
	}
	
	//  $firstname = fsql("restring", $_POST['firstname']); // mysqli_real_escape_string($conn, $_POST['firstname']);
	
	//  fsql("tablelist","users",$dbset['database']); // users tablosunu hücrelerini listeler..
	//  Isımlerını almak ıçın arraydan 'COLUMN_NAME' kullanın
	
    //  fsql("dblist",$dbset['database']); // db deki tabloları listeler..
	//  Isımlerını almak ıçın arraydan 'TABLE_NAME' kullanın 
    
	/*  fsql("insert","user",
	        "name,mail,pass,date",
	        "avel,avel@mail.com,password,date()"
		); 
		// user tablosuna ekleme yapar.
	*/
	
    /*
    $sql = "SELECT Lastname, Age FROM Persons ORDER BY Lastname";
    if ($result = fsql('query',$sql)) {
        while ($obj = fsql("fobject",$result)) {	// sql sorqusunu nesne olarak döndürür
            printf("%s (%s)\n", $obj->Lastname, $obj->Age);
        }
  
   
        fsql('freeresult',$result);
    }
    */
?>
