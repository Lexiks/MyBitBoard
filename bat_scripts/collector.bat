echo off
SET Miner=Worker1
FOR /F "tokens=1,3,5,7,9,11,13 delims=:# " %%A IN ('clocktweak.exe -r ^| Find "Temp"') DO (
wget "http://192.168.0.1/MyBitBoard/collector.php?MinerName=%MINER%&Temp=%%B&Cardid=%%A&Load=%%C&Core=%%E&Mem=%%F&Volt=%%G"
)
exit