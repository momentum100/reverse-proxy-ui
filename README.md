# reverse-proxy-ui - Сам себе Cloudflare
# 

Система управления реверс прокси - генерирует сертификаты для доменов и конфигурацию для веб сервера. Скрывает айпи твоего сервера.

1. Купи сервер Ubuntu 22 (без панелей, без веб сервера)
2. Зайди по ssh на севвер (используй клиент Putty)
3. Введи команду ниже дождись пароля
4. Зайти через браузер в панель.




## Installation (Ubuntu / Debian)

```bash
systemctl stop apache2; sudo apt-get update && \
sudo apt-get install -y curl git && \
curl -fsSL https://get.docker.com -o get-docker.sh && \
sudo sh ./get-docker.sh && \
git clone https://github.com/momentum100/reverse-proxy-ui && \
cd ./reverse-proxy-ui && \
sudo ./start.sh
```

Разработка телеграм ботов, автоматизация браузеров, фронт и бек разработка - телеграм @rq666 (https://t.me/rq666)
