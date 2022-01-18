Docker-compose
(docker compose為Docker的進階使用方式,透過編輯yml檔案來簡化docker指令與便於管理與佈署docker並可以利用一個檔案管理多個docker container串起服務架構鏈)
(dockerfile用於描述映像檔,docker-compose用於定義服務&網路環境&磁碟卷)

參考資料 :

https://docs.docker.com/compose/


install docker compose :

#sudo curl -L "https://github.com/docker/compose/releases/download/1.28.4/docker-compose-$(uname -s)-$(uname -m)" -o /usr/local/bin/docker-compose

#sudo chmod +x /usr/local/bin/docker-compose

#sudo ln -s /usr/local/bin/docker-compose /usr/bin/docker-compose


yml檔案為compose的核心，常用的主要結構有如下 :


version: 'XX' <--定義版本

services:

   service name: <--服務名稱指定

   image: <--容器名稱與版本

   restart: <--是否自動重啟容器

   environment: <--參數

   ports: <--設定端口對應關係

   volumes: <--設定掛載路徑

   depends_on: <--可以用來指定容器啟用的先後順序
   
       


