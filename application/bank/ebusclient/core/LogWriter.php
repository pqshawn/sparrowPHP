<?php
class LogWriter
{
    protected $iLogBuffer = '';
    
    private $datatime = null;

    public function __construct()
    {
        $this->datatime = new DateTime('now', new DateTimeZone('PRC'));
    }

    public function closeWriter($aLogFile)
    {
        fwrite($aLogFile, $this->iLogBuffer);
        fclose($aLogFile);
    }

    private function bufferAppend($s)
    {
        $this->iLogBuffer .= $s;
        echo $s;   //for debug
    }

    public function logNewLine($aLogString)
    {
       //设置为北京时间
		date_default_timezone_set('PRC');
		$this->datatime = date('Y-m-d H:i:s', time());
		$tLogTime = $this->datatime;
        $this->bufferAppend("\n$tLogTime ");
        $this->log($aLogString);
    }

    public function log($aLogString)
    {
        $aLogString = str_replace("\r", '', $aLogString);
        $aLogString = str_replace("\n", "\n                    ", $aLogString);
        $this->bufferAppend($aLogString);
    }

}

/*
$lw = new LogWriter();
$lw->logNewLine("������abc");
sleep(5);
$lw->logNewLine("������abcddddd");
$fout = fopen('php://stdout', 'w');
$lw->closeWriter($fout);
*/

?>