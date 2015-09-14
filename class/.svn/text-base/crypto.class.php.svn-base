<?php
/*
Classe gerada por gerador de classes CFG
Gerada em: 13/04/2015 13:03:03
Baseado em : mysql.gs:3306/dbautomato 
*/

class Crypto{

	public function Encrypt( $str ){ 
		$result = "";
		for( $x = 0; $x < strlen( $str ); $x++ ){
			$result .= $this->makeSenha( substr( $str, $x, 1) );
		}
		return $result;
	}
	
	private function makeSenha( $senha ){
		$wv2 = array("", "104", "109", "111", "116", "108", "120", "110", "103", "115", "117", "102", "121", "097", "122", "119", "101", "112", "105", "114", "118");
		$wb = ord( $senha );
		$wc = pow( (($wb / 100)+ 1) , (1/130) );
		$wc = substr($wc, 0, 7) ;
		$wp1 = substr( $wc, 4, 1);
		if( $wp1 == 0 ){
			$wp1 = 10;
		}
		$wp2 = substr( $wc, 5, 1);
		if( $wp2 == 0 ){
			$wp2 = 10;
		}
		$wp3 = substr( $wc, 6, 1);
		if( $wp3 == 0 ){
			$wp3 = 10;
		}
		$wl1 = $wv2[$wp1];
		$wl2 = $wv2[$wp2];
		$wl3 = $wv2[$wp3];					
		$wl4 = $wv2[$wp3+10];
		$wl5 = $wv2[$wp1+10];
		$wl6 = $wv2[$wp2+10];
		$wk1 = chr( $wl1 );
		$wk2 = chr( $wl2 );
		$wk3 = chr( $wl3 );
		$wk4 = chr( $wl4 );
		$wk5 = chr( $wl5 );
		$wk6 = chr( $wl6 );
		$wd1 = $wk1 . $wk2 . $wk3;
		if( count( $wv2 ) < 20 ){
			$wd2 = $wk3 . $wk1 . $wk2;
		}else{
			$wd2 = $wk4 . $wk5 . $wk6;
		}
		$we = $wd1 . $wd2;
		return $we;
	}
	
	public function Decrypt( $str ){
		$result = "";
		for( $x = 0; $x < strlen( $str ); $x++){
			$result .= $this->doRecoverSenha( substr( $str, $x, 6 ) );
			$x += 5;
		}
		return $result;
	}
	
	private function doRecoverSenha( $senha ){
		$wa1 = substr( $senha, 0, 1 );
		$wa2 = substr( $senha, 1, 1 );
		$wa3 = substr( $senha, 2, 1 );
		$wa4 = substr( $senha, 3, 1 );
		$wa5 = substr( $senha, 4, 1 );
		$wa6 = substr( $senha, 5, 1 );
	
		if( ord( $wa1 ) < 48 ){
			$wa1 = str_pad(ord($wa1), 1, "0", STR_PAD_LEFT);
			$wa2 = str_pad(ord($wa2), 1, "0", STR_PAD_LEFT);
			$wa3 = str_pad(ord($wa3), 1, "0", STR_PAD_LEFT);
			$wb1 = $wa1 . $wa2 . $wa3;
			$wv2 =  array("", "4", "9", "1", "6", "8", "2", "0", "3", "5", "7");
			$wp1 = array_search( substr( $wb1,0 ,1), $wv2 );
			if( $wp1 == 10 ){
				$wp1 = 0;
			}
			$wp2 = array_search( substr( $wb1,1 ,1), $wv2 );
			if( $wp2 == 10 ){
				$wp2 = 0;
			}
			$wp3 = array_search( substr( $wb1,2 ,1), $wv2 );
			if( $wp3 == 10 ){
				$wp3 = 0;
			}
		}else{
			$wa1 = str_pad(ord($wa1), 1, "0", STR_PAD_LEFT);
			$wa2 = str_pad(ord($wa2), 1, "0", STR_PAD_LEFT);
			$wa3 = str_pad(ord($wa3), 1, "0", STR_PAD_LEFT);
			$wb1 = $wa1 . $wa2 . $wa3;
			$wv2 =  array("","104","109","111","116","108","120","110","103","115","117", "102", "121", "097", "122", "119", "101", "112", "105", "114", "118");
			$wp1 = array_search( substr( $wb1, 0, 3 ), $wv2 );
			if( $wp1 == 10 ){
				$wp1 = 0;
			}
			$wp2 = array_search( substr( $wb1, 3, 3), $wv2 );
			if( $wp2 == 10 ){
				$wp2 = 0;
			}
			$wp3 = array_search( substr( $wb1, 6, 3), $wv2 );
			if( $wp3 == 10 ){
				$wp3 = 0;
			}
		}
		$wc1 = str_pad( $wp1, 1, "0", STR_PAD_LEFT) . str_pad( $wp2, 1, "0", STR_PAD_LEFT) . str_pad( $wp3, 1, "0", STR_PAD_LEFT);
		if( $wp1 == 0 ){
			$wp1 = 10;
		}
		if( $wp2 == 0 ){
			$wp2 = 10;
		}
		if( $wp3 == 0 ){
			$wp3 = 10;
		}
		if( $wa1 < 48 ){
			$wb2 = chr( $wv2[$wp3] ) . chr( $wv2[$wp1] ) . chr( $wv2[$wp2] );
		}else{
			$wb2 = chr( $wv2[$wp3 + 10] ) . chr( $wv2[$wp1 + 10] ) . chr( $wv2[$wp2 + 10] );
		}
		$wc2 = $wa4 . $wa5 . $wa6;
	
		if( $wb2 == $wc2 ){
			$wc = "1.00" . $wc1;
			$wc = floatval( $wc );
			$wd = round( ( pow($wc, 130)-1)*100, 0 );
			$we = chr( $wd );
		}
		return  $we;
	}

}
?>