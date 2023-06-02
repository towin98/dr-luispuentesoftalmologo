#!/bin/bash
BACKUP_DIR="/home/oftalmologica/app/backups"
BACKUP_FILE_NAME="$(date +"%d-%m-%y-%H%M%S.sql.gz")"

docker exec oftalmologia-db bash -c 'exec mysqldump --databases oftalmologia -h oftalmologia-db -u root --password=password' > gzip > "$BACKUP_DIR"/"$BACKUP_FILE_NAME"; 
