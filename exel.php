<?
# Автоподгрузка классов
function __autoload($name){ include("classes/_class.".$name.".php");}
# Класс конфига 
$config = new config;
# Функции
$func = new func;
# База данных
$db = new db($config->HostDB, $config->UserDB, $config->PassDB, $config->BaseDB);
$pref = $config->BasePrefix;


require 'PhpSpreadsheet/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;



$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A1', '№ п/п');
$sheet->setCellValue('B1', '№ лицевого счета');
$sheet->setCellValue('C1', 'Телефон');
$sheet->setCellValue('D1', 'Результат');


$i = 1;
	
	$db->Query("SELECT * FROM db_phone ");
	while ($row_view = $db->FetchArray())
	{
		
		$data1=mb_convert_encoding($row_view['ls'],"UTF-8","Windows-1251");
		$data2=mb_convert_encoding($row_view['phone'],"UTF-8","Windows-1251");
		
		
	if($row_view['res'] == 0)
	    $data3 = 'в очереди';
	if($row_view['res'] == 1)
	    $data3 = 'недоступен';
	if($row_view['res'] == 2)
	    $data3 = 'прослушал';
	if($row_view['res'] == 3)
	    $data3 = 'отбился';
	    

	    
	//	$data3=mb_convert_encoding($res,"UTF-8","Windows-1251");
		
		
		
		$i++;
		$count++;
		$sheet->setCellValue('A'.$i, $count);
		$sheet->setCellValue('B'.$i, $data1);
		$sheet->setCellValue('C'.$i, $data2);
		$sheet->setCellValue('D'.$i, $data3);

	
	}
	

$filename = 'sample-'.time().'.xlsx';



    
// Redirect output to a client's web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
 
// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.




// Жирный шрифт первой строки
$sheet = $spreadsheet->getActiveSheet();
//Create Styles Array
$styleArrayFirstRow = [
            'font' => [
                'bold' => true,
            ]
        ];
//Retrieve Highest Column (e.g AE)
$highestColumn = $sheet->getHighestColumn();
//set first row bold
$sheet->getStyle('A1:' . $highestColumn . '1' )->applyFromArray($styleArrayFirstRow);
// Конец Жирного шрифта первой строки


$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');

