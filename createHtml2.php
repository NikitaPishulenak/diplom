<?php
ini_set('display_errors','0');
chdir(dirname(__FILE__));
/*error_reporting(0);
ini_set( "display_errors", "0" );
*/
include 'config.php';
include 'core/db.php';
include 'core/ui.php';


if (isset($_GET['MODE'])){

	if ($_GET['MODE'] != 'DISPLAY')
		ui_redirect('index.php');
}
else
	ui_redirect('index.php');

$facult_list="1,2,3,4,6,8,9";
$facult_new_tables="6";
$facult_ignore = "7";
//$fac_inostr = "9,10,11";
$no_contest_budget_target_ids	= "2,5";
$no_contest_paid_target_ids	= "4";
$mfiu = '10,11,12,13,14,15,16';
$BUDGET = '1';
$PAID = '2';

	printHead();
//	echoTable($facult_ignore.','.$mfiu); // все бюджетники
//	echoTableForTarget($facult_ignore.',5'.','.$mfiu.',8,9','6', $facult_list); // целевики
//	echoTable($facult_ignore.','.$facult_list); // отдельно фарма зачем-то
//	echoTable($facult_ignore, false); // Платное
	echo '<br><hr style="color:red">';
//	echoTable($facult_ignore.','.$mfiu.',8,9', false); // все платники
//	echoTablePaidFarm(); // Платники фарма
/*echo <<<EOF
	<br />
	<a href="http://www.bsmu.by/pk/FARM_1.pdf">Информация об общем трудовом стаже абитуриентов, поступающих для получения второго и последующего высшего образования на первый курс фармацевтического факультета в заочной форме получения образования</a><br /><br />
	<a href="http://www.bsmu.by/pk/FARM_S.pdf">Информация об общем трудовом стаже абитуриентов, поступающих для получения второго и последующего высшего образования на второй курс фармацевтического факультета в заочной форме получения образования</a><br /><br /><br />
EOF;*/
	echoTablePO($facult_list.",6,".$mfiu); // ПО-шники


//	echoTable($facult_list.','.$facult_ignore, false, 'Факультет иностранных учащихся'); // все бюджетники МФИУ
//	echo '<h2>Собрание с деканом факультета по вопросам подачи документов и подсчета балла проводится ежедневно в 15:00 в аудитории №6</h2>';
//	echo '<h2>Consultation for documents admission and calculating of actual marks is held on every day basis at room №6 on 3:00 PM</h2>';
//	echo '<p>*Баллы для абитуриентов МФИУ отображаются с умножением на 10</p>';
//	echo '<p>*Marks for MFFS abiturients are indicated as multiplied by 10</p>';
	printStaticTable();
//	echo '<br><br><hr style="color: red">';
//	echoTablePO($facult_list.",6");
//	echoTable($facult_list);
//	echo '<br><br><hr style="color: red">';
//	printStaticTable();
	//echoTable($facult_ignore.','.$facult_list, false);
	//echoTableForTarget($facult_ignore,'','');
//	echoTableForTarget($facult_ignore.',1,2,3,4,5','6', '1,2,3,4,5,6');




function printStaticTable(){
$date = date("d-m-Y  G:")."00";
echo <<< EOF
<hr>
<h1>Данные за 01-08-2016  15:00</h1>
<h1 style="text-align:right; color: red;">Платная форма</h1>
<table class="export_table">
<thead>
	<tr>
		<td rowspan="3" colspan="2">Факультет,<br>специальность <br>(направление <br>специальности, <br>специализация)</td>
		<td rowspan="3">План приема</td>
		<td colspan="36">Подано заявлений от абитуриентов</td>
	</tr>
	<tr>
		<td rowspan="2">всего</td>
		<td colspan="4">в том числе</td>
		<td colspan="31">с суммой набранных баллов для конкурсного зачисления</td>
	</tr>

	<tr>		<td>без вступительных испытаний</td>
		<td>вне конкурса</td>
		<td>сверх конкурса</td>
		<td>по конкурсу</td><td>400 - 391</td><td>390 - 381</td><td>380 - 371</td><td>370 - 361</td><td>360 - 351</td><td>350 - 341</td><td>340 - 331</td><td>330 - 321</td><td>320 - 311</td><td>310 - 301</td><td>300 - 291</td><td>290 - 281</td><td>280 - 271</td><td>270 - 261</td><td>260 - 251</td><td>250 - 241</td><td>240 - 231</td><td>230 - 221</td><td>220 - 211</td><td>210 - 201</td><td>200 - 191</td><td>190 - 181</td><td>180 - 171</td><td>170 - 161</td><td>160 - 151</td><td>150 - 141</td><td>140 - 131</td><td>130 - 121</td><td>120 - 111</td><td>110 - 101</td><td>100 - 91</td>	</tr>
</thead>
<tbody>	<tr>
		<td colspan="2">Лечебный</td>
		<td>100</td>
		<td>131</td>
		<td>0</td>
		<td>3</td>
		<td>4</td>
		<td>124</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>7</td><td>14</td><td>12</td><td>24</td><td>16</td><td>15</td><td>5</td><td>8</td><td>1</td><td>1</td><td>1</td><td>2</td><td>1</td><td>-</td><td>1</td><td>2</td><td>2</td><td>4</td><td>2</td><td>2</td><td>4</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>	<tr>
		<td colspan="2">Медико-профилактический</td>
		<td>10</td>
		<td>12</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>12</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>5</td><td>2</td><td>2</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>-</td><td>1</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>	<tr>
		<td colspan="2">Педиатрический</td>
		<td>40</td>
		<td>60</td>
		<td>0</td>
		<td>0</td>
		<td>1</td>
		<td>59</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>4</td><td>10</td><td>5</td><td>4</td><td>5</td><td>6</td><td>4</td><td>2</td><td>4</td><td>1</td><td>1</td><td>2</td><td>2</td><td>4</td><td>-</td><td>2</td><td>-</td><td>-</td><td>2</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>	<tr>
		<td colspan="2">Стоматологический</td>
		<td>60</td>
		<td>79</td>
		<td>0</td>
		<td>1</td>
		<td>6</td>
		<td>72</td><td>-</td><td>-</td><td>-</td><td>6</td><td>7</td><td>18</td><td>16</td><td>10</td><td>5</td><td>1</td><td>2</td><td>-</td><td>2</td><td>-</td><td>1</td><td>-</td><td>-</td><td>1</td><td>1</td><td>-</td><td>-</td><td>-</td><td>2</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr><tr> 		<td rowspan=2>Фармацевтический</td>
		<td>Дневное</td>
		<td>30</td>

		<td>40</td>
		<td>0</td>
		<td>2</td>
		<td>1</td>
		<td>37</td><td>-</td><td>-</td><td>-</td><td>1</td><td>1</td><td>2</td><td>3</td><td>12</td><td>2</td><td>5</td><td>1</td><td>1</td><td>-</td><td>1</td><td>-</td><td>2</td><td>-</td><td>2</td><td>-</td><td>1</td><td>-</td><td>1</td><td>1</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>-</td></tr><tr>			<td>Заочное</td>
			<td>30</td>		<td>44</td>
		<td>0</td>
		<td>10</td>
		<td>0</td>
		<td>34</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>1</td><td>1</td><td>-</td><td>1</td><td>1</td><td>2</td><td>1</td><td>7</td><td>4</td><td>1</td><td>3</td><td>2</td><td>6</td><td>2</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>-</td><td>-</td><td>-</td></tr>
</tbody>
</table><h2>Платная форма, Фармация (2-ое высшее, 2-ой курс)</h2>
	<table class="export_table">
	<thead>
	<tr>
		<td>План</td>
		<td>Подано</td>
	</tr>
	</thead>
	<tbody>	<tr>
		<td>30</td>
		<td>59</td>
	</tr>
</tbody>
</table>
<br />
	<a href="http://www.bsmu.by/pk/FARM_1.pdf">Информация об общем трудовом стаже абитуриентов, поступающих для получения второго и последующего высшего образования на первый курс фармацевтического факультета в заочной форме получения образования</a><br /><br />
	<a href="http://www.bsmu.by/pk/FARM_S.pdf">Информация об общем трудовом стаже абитуриентов, поступающих для получения второго и последующего высшего образования на второй курс фармацевтического факультета в заочной форме получения образования</a><br /><br /><br />
<hr>
<h1>Данные за 15-07-2016  15:00</h1>
<h1 style="text-align:right; color: red;">Факультет иностранных учащихся</h1>
<table class="export_table">
<thead>
	<tr>
		<td rowspan="3" colspan="2">Факультет,<br>специальность <br>(направление <br>специальности, <br>специализация)</td>
		<td rowspan="3">План приема</td>
		<td colspan="36">Подано заявлений от абитуриентов</td>
	</tr>
	<tr>
		<td rowspan="2">всего</td>
		<td colspan="4">в том числе</td>
		<td colspan="31">с суммой набранных баллов для конкурсного зачисления</td>
	</tr>

	<tr>		<td>без вступительных испытаний</td>
		<td>вне конкурса</td>
		<td>сверх конкурса</td>
		<td>по конкурсу</td><td>400 - 391</td><td>390 - 381</td><td>380 - 371</td><td>370 - 361</td><td>360 - 351</td><td>350 - 341</td><td>340 - 331</td><td>330 - 321</td><td>320 - 311</td><td>310 - 301</td><td>300 - 291</td><td>290 - 281</td><td>280 - 271</td><td>270 - 261</td><td>260 - 251</td><td>250 - 241</td><td>240 - 231</td><td>230 - 221</td><td>220 - 211</td><td>210 - 201</td><td>200 - 191</td><td>190 - 181</td><td>180 - 171</td><td>170 - 161</td><td>160 - 151</td><td>150 - 141</td><td>140 - 131</td><td>130 - 121</td><td>120 - 111</td><td>110 - 101</td><td>100 - 91</td>	</tr>
</thead>
<tbody>	<tr>
		<td colspan="2">МФИУ (Леч., рус.)</td>
		<td>100</td>
		<td>118</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>118</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>2</td><td>-</td><td>5</td><td>5</td><td>9</td><td>10</td><td>11</td><td>12</td><td>17</td><td>11</td><td>15</td><td>11</td><td>7</td><td>2</td><td>1</td><td>-</td><td>-</td><td>-</td></tr>	<tr>
		<td colspan="2">МФИУ (Леч., англ.)</td>
		<td>105</td>
		<td>160</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>160</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>1</td><td>4</td><td>7</td><td>9</td><td>10</td><td>11</td><td>15</td><td>31</td><td>28</td><td>22</td><td>12</td><td>8</td><td>1</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>	<tr>
		<td colspan="2">МФИУ (Стом., рус.)</td>
		<td>70</td>
		<td>88</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>88</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>1</td><td>8</td><td>6</td><td>7</td><td>6</td><td>11</td><td>16</td><td>11</td><td>10</td><td>6</td><td>3</td><td>-</td><td>1</td><td>1</td><td>-</td><td>-</td><td>-</td></tr>	<tr>
		<td colspan="2">МФИУ (Стом., англ.)</td>
		<td>85</td>
		<td>114</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>114</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>4</td><td>2</td><td>7</td><td>22</td><td>19</td><td>25</td><td>19</td><td>7</td><td>4</td><td>-</td><td>3</td><td>2</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>	<tr>
		<td colspan="2">МФИУ (Мед-проф., рус.)</td>
		<td>5</td>
		<td>3</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>3</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>2</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>	<tr>
		<td colspan="2">МФИУ (Фарм., рус.)</td>
		<td>5</td>
		<td>11</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>11</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>-</td><td>-</td><td>-</td><td>1</td><td>2</td><td>-</td><td>2</td><td>-</td><td>3</td><td>2</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>	<tr>
		<td colspan="2">МФИУ (Фарм., англ.)</td>
		<td>10</td>
		<td>21</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>21</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>2</td><td>-</td><td>4</td><td>6</td><td>3</td><td>1</td><td>3</td><td>1</td><td>-</td><td>-</td><td>-</td></tr>
</tbody>
</table> <p>*Баллы для абитуриентов МФИУ отображаются с умножением на 10</p><p>*Marks for MFFS abiturients are indicated as multiplied by 10</p><hr>

<hr>

<h1>Данные за 14-07-2016  15:00</h1>
<h1 style="text-align:right; color: red;">Бюджетная форма</h1>
<table class="export_table">
<thead>
	<tr>
		<td rowspan="3" colspan="2">Факультет,<br>специальность <br>(направление <br>специальности, <br>специализация)</td>
		<td rowspan="3">План приема</td>
		<td colspan="36">Подано заявлений от абитуриентов</td>
	</tr>
	<tr>
		<td rowspan="2">всего</td>
		<td colspan="4">в том числе</td>
		<td colspan="31">с суммой набранных баллов для конкурсного зачисления</td>
	</tr>

	<tr>		<td>без вступительных испытаний</td>
		<td>вне конкурса</td>
		<td>на условиях целевой подготовки</td>
		<td>по конкурсу</td><td>400 - 391</td><td>390 - 381</td><td>380 - 371</td><td>370 - 361</td><td>360 - 351</td><td>350 - 341</td><td>340 - 331</td><td>330 - 321</td><td>320 - 311</td><td>310 - 301</td><td>300 - 291</td><td>290 - 281</td><td>280 - 271</td><td>270 - 261</td><td>260 - 251</td><td>250 - 241</td><td>240 - 231</td><td>230 - 221</td><td>220 - 211</td><td>210 - 201</td><td>200 - 191</td><td>190 - 181</td><td>180 - 171</td><td>170 - 161</td><td>160 - 151</td><td>150 - 141</td><td>140 - 131</td><td>130 - 121</td><td>120 - 111</td><td>110 - 101</td><td>100 - 91</td>	</tr>
</thead>
<tbody>	<tr>
		<td colspan="2">Лечебный</td>
		<td>250</td>
		<td>356</td>
		<td>12</td>
		<td>0</td>
		<td>137</td>
		<td>207</td><td>1</td><td>7</td><td>13</td><td>40</td><td>54</td><td>34</td><td>14</td><td>11</td><td>9</td><td>4</td><td>5</td><td>2</td><td>2</td><td>-</td><td>2</td><td>1</td><td>2</td><td>2</td><td>1</td><td>1</td><td>-</td><td>-</td><td>2</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>	<tr>
		<td colspan="2">Медико-профилактический</td>
		<td>50</td>
		<td>87</td>
		<td>0</td>
		<td>0</td>
		<td>27</td>
		<td>60</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>-</td><td>5</td><td>3</td><td>9</td><td>8</td><td>13</td><td>8</td><td>4</td><td>-</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td>1</td><td>2</td><td>1</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>	<tr>
		<td colspan="2">Педиатрический</td>
		<td>130</td>
		<td>199</td>
		<td>1</td>
		<td>0</td>
		<td>86</td>
		<td>112</td><td>-</td><td>-</td><td>1</td><td>1</td><td>4</td><td>20</td><td>16</td><td>22</td><td>17</td><td>16</td><td>4</td><td>1</td><td>2</td><td>2</td><td>2</td><td>-</td><td>-</td><td>-</td><td>1</td><td>1</td><td>-</td><td>1</td><td>1</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>	<tr>
		<td colspan="2">Стоматологический</td>
		<td>40</td>
		<td>74</td>
		<td>7</td>
		<td>0</td>
		<td>23</td>
		<td>44</td><td>1</td><td>4</td><td>7</td><td>11</td><td>4</td><td>7</td><td>7</td><td>1</td><td>-</td><td>-</td><td>1</td><td>-</td><td>-</td><td>-</td><td>1</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>	<tr>
		<td colspan="2">Фармацевтический</td>
		<td>50</td>
		<td>74</td>
		<td>2</td>
		<td>0</td>
		<td>23</td>
		<td>49</td><td>-</td><td>6</td><td>12</td><td>14</td><td>2</td><td>3</td><td>1</td><td>3</td><td>2</td><td>3</td><td>1</td><td>-</td><td>-</td><td>1</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td></tr>	<tr>
		<td colspan="2">Военно-медицинский (вооруж. силы)</td>
		<td>29</td>
		<td>44</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>44</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>3</td><td>5</td><td>4</td><td>5</td><td>7</td><td>5</td><td>2</td><td>3</td><td>1</td><td>1</td><td>1</td><td>-</td><td>-</td><td>-</td><td>1</td><td>-</td><td>2</td><td>-</td><td>1</td><td>-</td><td>-</td><td>1</td><td>1</td><td>-</td><td>-</td><td>-</td></tr>	<tr>
		<td colspan="2">Военно-медицинский (внутр. войска)</td>
		<td>1</td>
		<td>2</td>
		<td>0</td>
		<td>0</td>
		<td>0</td>
		<td>2</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>-</td><td>1</td><td>-</td></tr>
</tbody>
</table>
<h1 style="text-align:right; color: red;">Целевая подготовка</h1>
<table class="export_table_c">
<thead>
	<tr>
		<td rowspan="2" colspan="3">Факультет,<br>специальность <br>(направление <br>специальности, <br>специализация)</td>
		<td rowspan="2">План</td>
		<td colspan="32">Подано заявлений от абитуриентов с суммой набранных баллов на условии целевой подготовки</td>
	</tr>
	<tr>
		<td>Всего</td><td>400 - 391</td><td>390 - 381</td><td>380 - 371</td><td>370 - 361</td><td>360 - 351</td><td>350 - 341</td><td>340 - 331</td><td>330 - 321</td><td>320 - 311</td><td>310 - 301</td><td>300 - 291</td><td>290 - 281</td><td>280 - 271</td><td>270 - 261</td><td>260 - 251</td><td>250 - 241</td><td>240 - 231</td><td>230 - 221</td><td>220 - 211</td><td>210 - 201</td><td>200 - 191</td><td>190 - 181</td><td>180 - 171</td><td>170 - 161</td><td>160 - 151</td><td>150 - 141</td><td>140 - 131</td><td>130 - 121</td><td>120 - 111</td><td>110 - 101</td><td>100 - 91</td>	</tr>
</thead>
<tbody><tr>				<td clospan="2" rowspan="6">Лечебный</td>				<td colspan="2">Бр</td>
				<td>15</td>
				<td>22</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>2 </td><td>4 </td><td>6 </td><td>2 </td><td>1 </td><td>3 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>2 </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Вт</td>
				<td>10</td>
				<td>14</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td>1 </td><td>4 </td><td>1 </td><td>1 </td><td> -  </td><td>3 </td><td>2 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Го</td>
				<td>10</td>
				<td>12</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td>3 </td><td>2 </td><td>1 </td><td>2 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td>1 </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Гр</td>
				<td>10</td>
				<td>9</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td>1 </td><td>2 </td><td> -  </td><td>1 </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td>1 </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Мн</td>
				<td>30</td>
				<td>44</td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td>6 </td><td>5 </td><td>5 </td><td>6 </td><td>6 </td><td>3 </td><td>2 </td><td>2 </td><td> -  </td><td> -  </td><td>1 </td><td>1 </td><td> -  </td><td> -  </td><td>1 </td><td>2 </td><td> -  </td><td> -  </td><td> -  </td><td>2 </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Мг</td>
				<td>25</td>
				<td>36</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>2 </td><td>5 </td><td>1 </td><td>2 </td><td>3 </td><td>1 </td><td>3 </td><td>3 </td><td>3 </td><td>3 </td><td>2 </td><td>3 </td><td>1 </td><td>1 </td><td>1 </td><td> -  </td><td> -  </td><td>2 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr><tr>				<td clospan="2" rowspan="6">Медико-профилактический</td>				<td colspan="2">Бр</td>
				<td>4</td>
				<td>6</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td>1 </td><td>1 </td><td>1 </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Вт</td>
				<td>4</td>
				<td>6</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td>1 </td><td>2 </td><td>1 </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Го</td>
				<td>3</td>
				<td>4</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td>2 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Гр</td>
				<td>3</td>
				<td>2</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Мн</td>
				<td>3</td>
				<td>6</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td>1 </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td>2 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Мг</td>
				<td>3</td>
				<td>3</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td>1 </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr><tr>				<td clospan="2" rowspan="6">Педиатрический</td>				<td colspan="2">Бр</td>
				<td>10</td>
				<td>15</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>2 </td><td>4 </td><td>1 </td><td>3 </td><td> -  </td><td>1 </td><td> -  </td><td>1 </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Вт</td>
				<td>8</td>
				<td>13</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td>1 </td><td>1 </td><td> -  </td><td>1 </td><td>3 </td><td>2 </td><td>2 </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Го</td>
				<td>10</td>
				<td>15</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td>1 </td><td> -  </td><td>2 </td><td>2 </td><td>1 </td><td>2 </td><td> -  </td><td>2 </td><td>2 </td><td> -  </td><td>1 </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Гр</td>
				<td>8</td>
				<td>7</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td>1 </td><td>1 </td><td>1 </td><td>1 </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Мн</td>
				<td>8</td>
				<td>14</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>4 </td><td>2 </td><td>4 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td>2 </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Мг</td>
				<td>8</td>
				<td>22</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td>4 </td><td>4 </td><td>2 </td><td>3 </td><td> -  </td><td>2 </td><td>4 </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr><tr>				<td clospan="2" rowspan="6">Стоматологический</td>				<td colspan="2">Бр</td>
				<td>3</td>
				<td>4</td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td>1 </td><td>1 </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Вт</td>
				<td>3</td>
				<td>3</td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Го</td>
				<td>3</td>
				<td>6</td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td>1 </td><td>3 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Гр</td>
				<td>2</td>
				<td>2</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Мн</td>
				<td>2</td>
				<td>4</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>2 </td><td>1 </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td colspan="2">Мг</td>
				<td>3</td>
				<td>4</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td>1 </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td rowspan="13">Фармацевтический</td><tr>					<td rowspan="2">Бр</td>				<td>УЗО</td>
				<td>1</td>
				<td> - </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td>РУП</td>
				<td>2</td>
				<td>4</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr><tr>					<td rowspan="2">Вт</td>				<td>УЗО</td>
				<td> - </td>
				<td> - </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td>РУП</td>
				<td> - </td>
				<td> - </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr><tr>					<td rowspan="2">Го</td>				<td>УЗО</td>
				<td>2</td>
				<td>2</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td>РУП</td>
				<td>2</td>
				<td>4</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td>1 </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr><tr>					<td rowspan="2">Гр</td>				<td>УЗО</td>
				<td>2</td>
				<td>1</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td>РУП</td>
				<td>2</td>
				<td>1</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr><tr>					<td rowspan="2">Мн</td>				<td>УЗО</td>
				<td>2</td>
				<td>3</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td>РУП</td>
				<td>3</td>
				<td>3</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr><tr>					<td rowspan="2">Мг</td>				<td>УЗО</td>
				<td>2</td>
				<td>3</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>2 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr>				<td>РУП</td>
				<td>2</td>
				<td>2</td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td><td>1 </td><td> -  </td><td> -  </td><td> -  </td><td> -  </td></tr></tbody>
</table>
<br><br><hr style="color: red">
EOF;
}


function printHead()
{
$date = date("d-m-Y  G:")."00";
echo <<< EOF
<!DOCTYPE html>
<HTML>
<HEAD>
<style>

.export_table {
	border: 5px double gray;
	border-collapse: collapse;
}

.export_table thead td {
	border: 1px solid black;
	padding: 5px;
	text-align: center;
	font-weight: bold;
}

.export_table tbody td {
	border-bottom: 1px dashed black;
	text-align: center;
	font-size: 1.1em;
	padding: 10px 3px;
}

.export_table tbody tr td:first-child {
	font-weight: bold;
}

.export_table tbody tr:last-child td {
	border-bottom: 2px double black
}


.export_table tbody td {
	border: 1px dashed black;
}

/*
.export_table tbody tr td:nth-child(2n+10){
	background: #e0e0e0;	
}*/


.export_table_c {
	border: 5px double gray;
	border-collapse: collapse;
}

.export_table_c thead td {
	border: 1px solid black;
	padding: 5px;
	text-align: center;
	font-weight: bold;
}

.export_table_c tbody td {
	border-bottom: 1px dashed black;
	text-align: center;
	font-size: 1.1em;
	padding: 10px 3px;
}

.export_table_c tbody tr td:first-child {
	font-weight: bold;
}

.export_table_c tbody tr:last-child td {
	border-bottom: 2px double black
}

.export_table_c tbody tr td:nth-child(2n+5){
	//background: #e0e0e0;	
}

.export_table_c tbody td {
	border: 1px solid black;
}


</style>

<TITLE>Контрольные цифры</TITLE>
</HEAD>
<BODY>
<h1>Данные за $date</h1>
EOF;
}

function echoTablePaidFarm()
{
echo <<<EOF
<h2>Платная форма, Фармация (2-ое высшее, 2-ой курс)</h2>
	<table class="export_table">
	<thead>
	<tr>
		<td>План</td>
		<td>Подано</td>
	</tr>
	</thead>
	<tbody>
EOF;
 mysql_select_db("afx");
$sql="SELECT `id_fixation` FROM `db_fixation` ORDER BY `id_fixation` DESC LIMIT 1";
$AUTOFIXATION = mysql_result(mysql_query($sql),0);
mysql_select_db('admx');
$plan =  mysql_result(mysql_query("SELECT total FROM db_planform WHERE time_form_id=5  AND edu_form_id=2 AND faculty_id = 6"),0);
mysql_select_db('afx');
$income = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty IN (6) AND state_id = 1 AND time_form_id = 5"),0);
echo <<<EOF
	<tr>
		<td>$plan</td>
		<td>$income</td>
	</tr>
</tbody>
</table>
EOF;
}

function echoTableForTarget($facult_ignore = null, $needDetail = '', $needRegion = 'all')
{
//....................... ЗАНЧЕНИЯ ПЕРЕДАВАЕМЫХ ПАРАМЕТРОВ В ФУНКЦИЮ .....................//
// needDetail - с разбивкой по типу целевых, указать факультеты, например '1, 2'          //
//		пока нужно только для Фармы, т.е. '6' (УЗО/ФАРМ)                          //
//                                                                                        //
// needRegion                                                                             //
//	all - (по умолчанию) разбивает по регионам все факультеты                         //
//	1,2,3 - указывает факультеты с разбивкой                                          //
//	 -1   - без разбивки                                                              //
//........................................................................................//

mysql_select_db("admx");


$detail = Array();
	if ($needDetail)
		$detail = explode(',', $needDetail);

$needRegions = Array();
if ($needRegion == 'all')
	{
	//$needRegion = '';
	$result = mysql_query("SELECT id FROM db_faculty WHERE id NOT IN (".$facult_ignore.") ORDER BY id");
	while($as = mysql_fetch_array($result))
		array_push($needRegions, $as[0]);
	$needRegion = implode(',', $needRegions);
	}
else
	{

	if($needRegion == '-1') {
		$needRegion = '';
	}
	else

	if ($needRegion)
		$needRegions = explode(',',$needRegion);

	}


$facult_rowspan = sizeOf($needRegions);

	$count=0;

	for ($i=400; $i>90; $i=$i-10)
	{
		$count++;
	}
	$count++;
	echo <<<EOF

<h1 style="text-align:right; color: red;">Целевая подготовка</h1>
<table class="export_table_c">
<thead>
	<tr>
		<td rowspan="2" colspan="3">Факультет,<br>специальность <br>(направление <br>специальности, <br>специализация)</td>
		<td rowspan="2">План</td>
		<td colspan="$count">Подано заявлений от абитуриентов с суммой набранных баллов на условии целевой подготовки</td>
	</tr>
	<tr>
		<td>Всего</td>
EOF;
for ($i=400; $i>90; $i=$i-10)
{

 echo '<td>'.$i.' - '.($i-9).'</td>';
}

echo <<<EOF
	</tr>
</thead>
<tbody>
EOF;

$dbRegions = Array();
$dbCellTypes = Array();
$dbFaculty = Array();


 mysql_select_db("admx");
 $result = mysql_query('SELECT id_region, abbr FROM db_region');
 while ($row = mysql_fetch_array($result))
	$dbRegions[$row[0]] = $row[1];

 $result = mysql_query('SELECT id_targetcell, abbr FROM db_targetcell');
 while ($row = mysql_fetch_array($result))
	$cellTypes[$row[0]] = $row[1];

 $result = mysql_query('SELECT id_targetcell, abbr FROM db_targetcell');
 while ($row = mysql_fetch_array($result))
	$dbCellTypes[$row[0]] = $row[1];


mysql_select_db("admx");

 $where = ($facult_ignore) ? " WHERE id NOT IN(".$facult_ignore.")" : "";
 $result = mysql_query('SELECT id, name FROM db_faculty'.$where);
 while ($row = mysql_fetch_array($result))
	$dbFaculty[$row[0]] = $row[1];

/*
print_r($dbRegions);
print_r($dbcellTypes);
print_r($dbFaculty);
  */

 mysql_select_db("afx");
$sql="SELECT `id_fixation` FROM `db_fixation` ORDER BY `id_fixation` DESC LIMIT 1";
$AUTOFIXATION = mysql_result(mysql_query($sql),0);

$regionsKeys = array_keys($dbRegions);
$facultyKeys = array_keys($dbFaculty);
$cellTypesKeys = array_keys($dbCellTypes);
$countRegions = sizeOf($regionsKeys);
$countCellTypes = sizeOf($cellTypesKeys);

	for ($f = 0; $f < sizeOf($facultyKeys); $f++)
	{
		$span = "";
		if (in_array($facultyKeys[$f], $needRegions))
		{
			if (in_array($facultyKeys[$f], $detail))
			{
			$text = $dbFaculty[$facultyKeys[$f]];
			$rspan = $countRegions*$countCellTypes+1;
				echo <<<EOF
				<td rowspan="$rspan">$text</td>
EOF;
			for($r = 0; $r < $countRegions; $r++)
			{
				echo "<tr>";
				$text = $dbRegions[$regionsKeys[$r]];
				echo <<<EOF
					<td rowspan="$countCellTypes">$text</td>
EOF;
				for($t=0; $t < $countCellTypes; $t++)
				{
				$text   = $dbCellTypes[$cellTypesKeys[$t]];
				mysql_select_db("admx");
				$plan = mysql_result(mysql_query("SELECT SUM(plan) FROM db_plancell WHERE faculty_id = ".$facultyKeys[$f]." AND region_id = ".$regionsKeys[$r]." AND targetcell_id = ".$cellTypesKeys[$t]),0);
				$plan = ($plan) ? $plan : ' - ';
				mysql_select_db("afx");
				$count = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$facultyKeys[$f]." AND state_id = 1 AND target = 1 AND region_cell = ".$regionsKeys[$r]." AND target_cell = ".$cellTypesKeys[$t]),0);
				$count = ($count) ? $count : ' - ';
				echo <<<EOF
				<td>$text</td>
				<td>$plan</td>
				<td>$count</td>
EOF;
			for ($i=400; $i>90; $i=$i-10)
			{
			$ii = $i-9;
			$sql = "SELECT COUNT(person_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND state_id = 1 AND total <= ".$i." AND total >=".$ii." AND target = 1 AND faculty = ".$facultyKeys[$f]." AND region_cell = ".$regionsKeys[$r]." AND target_cell = ".$cellTypesKeys[$t];
			$text = mysql_result(mysql_query($sql),0);
			$text = ($text) ? $text : ' - ';
			 echo '<td>'.$text.' </td>';
			}

			echo "</tr>";
				
				}
			}
			}
			else
			{
			echo "<tr>";
			$text = $dbFaculty[$facultyKeys[$f]];
			$rspan = $countRegions;
				echo <<<EOF
				<td clospan="2" rowspan="$rspan">$text</td>
EOF;
			for($r = 0; $r < $countRegions; $r++)
			{
				$text = $dbRegions[$regionsKeys[$r]];
				mysql_select_db("admx");
				$plan = mysql_result(mysql_query("SELECT SUM(plan) FROM db_plancell WHERE faculty_id = ".$facultyKeys[$f]." AND region_id = ".$regionsKeys[$r]),0);
				$plan = ($plan) ? $plan : ' - ';
				mysql_select_db("afx");
				$count = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$facultyKeys[$f]." AND state_id = 1 AND target = 1 AND region_cell = ".$regionsKeys[$r]),0);
				$count = ($count) ? $count : ' - ';
				echo <<<EOF
				<td colspan="2">$text</td>
				<td>$plan</td>
				<td>$count</td>
EOF;
	
			for ($i=400; $i>90; $i=$i-10)
			{
			$ii = $i-9;
			$sql = "SELECT COUNT(person_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND state_id = 1 AND total <= ".$i." AND total >=".$ii." AND target = 1 AND faculty = ".$facultyKeys[$f]." AND region_cell = ".$regionsKeys[$r];
			$text = mysql_result(mysql_query($sql),0);
			$text = ($text) ? $text : ' - ';
			 echo '<td>'.$text.' </td>';
			}

			echo "</tr>";
				
			}
			}
		}
		else
		{
			echo "<tr>";
			$text = $dbFaculty[$facultyKeys[$f]];
			mysql_select_db("admx");
			$plan = mysql_result(mysql_query("SELECT SUM(plan) FROM db_plancell WHERE faculty_id = ".$facultyKeys[$f]),0);
			$plan = ($plan) ? $plan : ' - ';
			mysql_select_db("afx");
			$count = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$facultyKeys[$f]." AND state_id = 1 AND target = 1"),0);
			$count = ($count) ? $count : ' - ';
			echo <<<EOF
				<td colspan="3">$text</td>
				<td>$plan</td>
				<td>$count</td>
	
EOF;
			for ($i=400; $i>90; $i=$i-10)
			{
			$ii = $i-9;
			$sql = "SELECT COUNT(person_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND state_id = 1 AND total <= ".$i." AND total >=".$ii." AND target = 1 AND faculty = ".$facultyKeys[$f];
			$text = mysql_result(mysql_query($sql),0);
			$text = ($text) ? $text : ' - ';
			 echo '<td>'.$text.'</td>';
			}

			echo "</tr>";
		}
	}

echo <<<EOF
</tbody>
</table>
EOF;
}

function echoTable($facult_ignore, $isBudget = true, $caption = '')
{                      

$edu_form = ($isBudget) ? 1 : 2;
$head_text = ($isBudget) ? 'Бюджетная форма' : 'Платная форма';
$head_text = ($caption) ? $caption : $head_text;
$cel_text = ($isBudget) ? 'на условиях целевой подготовки' :'сверх конкурса';
mysql_select_db("admx");

	$str="";

	$count=0;

	for ($i=400; $i>90; $i=$i-10)
	{
		$count++;
	}
//	$fcount = $count + 6; // Full table colspan;
	$fcount = $count + 5; // Full table colspan;
	echo <<<EOF

<h1 style="text-align:right; color: red;">$head_text</h1>
<table class="export_table">
<thead>
	<tr>
		<td rowspan="3" colspan="2">Факультет,<br>специальность <br>(направление <br>специальности, <br>специализация)</td>
		<td rowspan="3">План приема</td>
		<td colspan="$fcount">Подано заявлений от абитуриентов</td>
	</tr>
	<tr>
		<td rowspan="2">всего</td>
		<td colspan="4">в том числе</td>
		<td colspan="$count">с суммой набранных баллов для конкурсного зачисления</td>
	</tr>

	<tr>
EOF;
//		<td>всего</td>

//		<td>в том числе, на условиях целевой подготовки</td>
//		<td>на условиях целевой подготовки</td>
echo <<< EOF
		<td>без вступительных испытаний</td>
		<td>вне конкурса</td>
		<td>$cel_text</td>
		<td>по конкурсу</td>
EOF;
for ($i=400; $i>90; $i=$i-10)
{

 echo '<td>'.$i.' - '.($i-9).'</td>';
}

echo <<<EOF
	</tr>
</thead>
<tbody>
EOF;

mysql_select_db("afx");
$sql="SELECT `id_fixation` FROM `db_fixation` ORDER BY `id_fixation` DESC LIMIT 1";
$AUTOFIXATION = mysql_result(mysql_query($sql),0);
//echo $AUTOFIXATION;


mysql_select_db("admx");
$sql = "SELECT id, name FROM db_faculty WHERE id NOT IN(".$facult_ignore.")";

$result = mysql_query($sql);
while ($row = mysql_fetch_array($result))
{
	$idf = $row[0];
	mysql_select_db("admx");
	$plan_cel =   mysql_result(mysql_query("SELECT SUM(plan) FROM db_plancell WHERE faculty_id = ".$row[0]),0);
//	$plan_total = mysql_result(mysql_query("SELECT SUM(total) FROM db_planform WHERE faculty_id = ".$row[0]. " AND edu_form_id = ".$edu_form),0);
	if ($idf == 6 && $edu_form == 2)
	{
	for ($ri=1; $ri<3; $ri++)
	{       mysql_select_db("admx");
		$plan_total = mysql_result(mysql_query("SELECT SUM(total) FROM db_planform WHERE faculty_id = ".$row[0]. " AND edu_form_id = ".$edu_form." AND time_form_id NOT IN (5) AND time_form_id=".$ri),0);
		$plan_cel =   mysql_result(mysql_query("SELECT SUM(plan) FROM db_plancell WHERE faculty_id = ".$row[0]),0);
		mysql_select_db("afx");
		$total = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND time_form_id NOT IN (5) AND time_form_id=".$ri),0);
		$to_cel = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND target = 1 AND time_form_id=".$ri),0);
		$plan_cel = " - ";
		$bez_isp = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND target IN (2,5)  AND time_form_id NOT IN (5) AND time_form_id=".$ri),0);
		$vne_konkurs = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND target = 4 AND time_form_id=".$ri),0);
		$sv_konkurs = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND target = 6 AND time_form_id=".$ri),0);
		$to_konkurs = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND target = 3 AND time_form_id=".$ri), 0);
	echo"<tr>";

	if ($ri == 1)
		echo <<< EOF
 		<td rowspan=2>$row[1]</td>
		<td>Дневное</td>
		<td>$plan_total</td>


EOF;
//	<td rowspan="2">$plan_cel</td>
	else
		echo <<<EOF
			<td>Заочное</td>
			<td>$plan_total</td>
EOF;
//		<td>$to_cel</td>
	$tot = ($isBudget) ? $total : $total-$to_cel;
	$sv_konkurs = ($isBudget) ? $to_cel : $sv_konkurs;
	echo <<< EOF
		<td>$tot</td>
		<td>$bez_isp</td>
		<td>$vne_konkurs</td>
		<td>$sv_konkurs</td>
		<td>$to_konkurs</td>
EOF;
	for ($i=400; $i>90; $i=$i-10)
	{
	$str = '';
	$ii = $i-9;
	$sql = "SELECT COUNT(person_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND edu_form = ".$edu_form." AND state_id = 1 AND total <= ".$i." AND total >=".$ii." AND faculty = ".$row[0]." AND time_form_id NOT IN (5)  AND target=3 AND time_form_id=".$ri;
	$str = mysql_result(mysql_query($sql),0);
	$str = ($str) ? $str : '-';
	 echo '<td>'.$str.'</td>';
	}
	echo '</tr>';

	}
	} 
else
	{
	mysql_select_db("admx");
	$plan_total = mysql_result(mysql_query("SELECT SUM(total) FROM db_planform WHERE faculty_id = ".$row[0]. " AND edu_form_id = ".$edu_form." AND time_form_id NOT IN (5)"),0);
	mysql_select_db("afx");
	$total = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND time_form_id NOT IN (5)"),0);
	$to_cel = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND target = 1"),0);
	$plan_cel = ($edu_form == 2) ? " - " : $plan_cel;
	$bez_isp = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND target IN (2,5)  AND time_form_id NOT IN (5)"),0);
	$vne_konkurs = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND target = 4"),0);
	$sv_konkurs = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND target=6"),0);
	$to_konkurs = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND edu_form = ".$edu_form." AND state_id = 1 AND target=3 AND time_form_id NOT IN (5)"),0);

//		<td>$to_cel</td>
//		<td>$plan_cel</td>

	$tot = ($isBudget) ? $total : $total-$to_cel;
	$sv_konkurs = ($isBudget)? $to_cel : $sv_konkurs;
echo <<< EOF
	<tr>
		<td colspan="2">$row[1]</td>
		<td>$plan_total</td>
		<td>$tot</td>
		<td>$bez_isp</td>
		<td>$vne_konkurs</td>
		<td>$sv_konkurs</td>
		<td>$to_konkurs</td>
EOF;
	for ($i=400; $i>90; $i=$i-10)
	{
	$str = '';
	$ii = $i-9;
	$sql = "SELECT COUNT(person_id) FROM db_fixed_target WHERE fixation_id=".$AUTOFIXATION." AND edu_form=".$edu_form." AND state_id=1 AND total<= ".$i." AND total>=".$ii." AND faculty = ".$row[0]." AND time_form_id NOT IN (5)  AND target=3";
	$str = mysql_result(mysql_query($sql),0);
	$str = ($str) ? $str : '-';
	 echo '<td>'.$str.'</td>';
	}
	echo '</tr>';
	}
}


	echo<<<EOF

</tbody>
</table>
EOF;


}




function echoTablePO($facult_ignore)
{                      

$head_text = "Подготовительное отделение";
mysql_select_db("admx");

	$str="";

	$count=0;

	for ($i=400; $i>40; $i=$i-10)
	{
		$count++;
	}
	$count++;
	$fcount = $count + 1; // Full table colspan;
	echo <<<EOF

<h1 style="text-align:right; color: red;">$head_text</h1>
<table class="export_table">
<thead>
	<tr>
		<td rowspan="3">Факультет,<br>специальность <br>(направление <br>специальности, <br>специализация)</td>
		<td rowspan="3">План приема</td>
		<td colspan="$fcount">Подано заявлений от абитуриентов</td>
	</tr>
	<tr>
			<td rowspan="2">всего</td>
			<td colspan="$count">с суммой набранных баллов для конкурсного зачисления</td>
	</tr>
	<tr>
	<td>Собеседование</td>
EOF;
for ($i=400; $i>40; $i=$i-10)
{

 echo '<td>'.$i.' - '.($i-9).'</td>';
}

echo <<<EOF
	</tr>
</thead>
<tbody>
EOF;

mysql_select_db("afx");
$sql="SELECT `id_fixation` FROM `db_fixation` ORDER BY `id_fixation` DESC LIMIT 1";
$AUTOFIXATION = mysql_result(mysql_query($sql),0);
//echo $AUTOFIXATION;


mysql_select_db("admx");
$sql = "SELECT id, name FROM db_faculty WHERE id NOT IN(".$facult_ignore.")";

$result = mysql_query($sql);
while ($row = mysql_fetch_array($result))
{
	$idf = $row[0];
	mysql_select_db("admx");
	$plan_total = mysql_result(mysql_query("SELECT SUM(total) FROM db_planform WHERE faculty_id = ".$row[0]),0);
	mysql_select_db("afx");
	$total = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND state_id = 1"),0);
	$sobes = mysql_result(mysql_query("SELECT COUNT(fixation_id) FROM db_fixed_target WHERE fixation_id = ".$AUTOFIXATION." AND faculty = ".$row[0]. " AND state_id = 1 AND person_id IN (SELECT id FROM admx.db_person WHERE cct_id != 1 OR bct_id != 1 OR lct_id != 1)"),0);

	echo <<< EOF
	<tr>
		<td>$row[1]</td>
		<td>$plan_total</td>
		<td>$total</td>
		<td>$sobes</td>
EOF;
	for ($i=400; $i>40; $i=$i-10)
	{
	$str = '';
	$ii = $i-9;
	$sql = "SELECT COUNT(person_id) FROM db_fixed_target WHERE fixation_id=".$AUTOFIXATION." AND state_id = 1 AND total<= ".$i." AND total>=".$ii." AND faculty = ".$row[0]." AND person_id NOT IN (SELECT id FROM admx.db_person WHERE cct_id!=1 OR bct_id!=1 OR lct_id!=1)";
	$str = mysql_result(mysql_query($sql),0);
	$str = ($str) ? $str : '-';
	 echo '<td>'.$str.'</td>';
	}
	echo '</tr>';
	}


	echo<<<EOF

</tbody>
</table>
EOF;
}
?>