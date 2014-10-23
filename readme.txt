0. 環境
請先確保你的 apache 是可以正常運行 CodeIgniter，以及可以正常開啓 controller method，
首先開啓終端機，並且 cd 至目錄 mywall 下。

1. 複製建立 database file。
終端機 cp resource/share/database.php application/config/database.php
修改 database.php 資料，建議 $db['default']['database'] = 'mywall';
然後輸入你的 MySQL 帳號、密碼。
並且在你的 MySQL 建立一張表，建議名稱叫做 mywall。

2. 建立 upload 資料夾
終端機 mkdir upload

3. 建立 cell cache 資料夾
終端機 mkdir application/cell/cache

4. 建立 file cache 資料夾
終端機 mkdir application/cache/file

5. 建立 output cache 資料夾
終端機 mkdir application/cache/output

6. 建立 log file
終端機 touch application/logs/query-log.log
終端機 touch application/logs/delay_job-log.log

7. 設定權限
終端機 chmod 777 temp
終端機 chmod 777 upload
終端機 chmod 777 application/cell/cache
終端機 chmod 777 application/cache/file
終端機 chmod 777 application/cache/output
終端機 chmod 777 application/logs/query-log.log
終端機 chmod 777 application/logs/delay_job-log.log

8. 初始網站 (初始資料會到 style.fg 去抓，所以會有點久
開啓瀏覽器 http://url/demo/c

