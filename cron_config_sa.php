<?php
include 'config.php';
include 'core/db.php';

			echo date("Y-m-d:H")."  Start crone budget    <br>";
				
				$str=file_get_contents('http://pktest.bsmu.by/discrete.php?fc=1&tf=1&ef=1&afx=0&mfx=0&raw=on');
				$str.=file_get_contents('http://pktest.bsmu.by/discrete.php?fc=2&tf=1&ef=0&afx=0&mfx=0&raw=on');
				$str.=file_get_contents('http://pktest.bsmu.by/discrete.php?fc=3&tf=1&ef=1&afx=0&mfx=0&raw=on');
				$str.=file_get_contents('http://pktest.bsmu.by/discrete.php?fc=4&tf=1&ef=1&afx=0&mfx=0&raw=on');
				$str.=file_get_contents('http://pktest.bsmu.by/discrete.php?fc=5&tf=1&ef=1&afx=0&mfx=0&raw=on');
				$str.=file_get_contents('http://pktest.bsmu.by/discrete.php?fc=6&tf=1&ef=1&afx=0&mfx=0&raw=on');
				if(!is_dir("/statichtml_ts_ma")) mkdir("/statichtml_ts", 0777);     
				$file="/statichtml_ts_ma/budget_".date("m-d-y--H-i-s").".html";    
				$fp = fopen($file, 'w+');
				fwrite($fp, $str);
				fclose($fp); 
				if(!is_dir("/statichtml_ma")) mkdir("/var/www/html/statichtml", 0777);
				$file="/statichtml/budget.html";    
				$fp = fopen($file, 'w+');
				fwrite($fp, $str);
				fclose($fp); 
				$typeb=$arr[2];
				$idb=$arr[3];

			

			
				echo date("Y-m-d:H")."  Start crone paid    ";


				$str=file_get_contents('http://pktest.bsmu.by/discrete_paid.php?fc=0&tf=0&afx=0&mfx=0&raw=on');
				if(!is_dir("/var/www/html/statichtml_ts_ma")) mkdir("/var/www/html/statichtml_ts", 0777);     
				$file="/var/www/html/statichtml_ts_ma/budget_".date("m-d-y--H-i-s").".html";    
				$fp = fopen($file, 'w+');
				fwrite($fp, $str);
				fclose($fp); 
				if(!is_dir("/var/www/html/statichtml_ma")) mkdir("/var/www/html/statichtml", 0777); 
				$file="/var/www/html/statichtml/paid.html";    
				$fp = fopen($file, 'w+');
				fwrite($fp, $str);
				fclose($fp); 
				$typep=$arr[2];
				$idp=$arr[3];







