#!/bin/bash

echo "正在生成 OpenAPI 规范文件..."
./vendor/bin/openapi index.php -b index.php -o openapi.json

if [ ! -f openapi.json ]; then
  echo "错误：openapi.json 生成失败，请检查注解是否正确"
  exit 1
fi

echo "正在同步到 Apifox..."
RESPONSE=$(curl -s -X POST "https://api.apifox.com/api/v1/projects/7987812/import-data" \
  -H "Authorization: Bearer afxp_42b3e2cEujBARYX3M3cTk6BqwiLLFkwIisoP" \
  -H "Content-Type: application/json" \
  -H "X-Apifox-Version: 2022-11-16" \
  -d "{
    \"importFormat\": \"openapi\",
    \"importDataType\": \"apiDefinition\",
    \"importOptions\": {
      \"apiOverwriteRule\": \"methodAndPath\",
      \"folderOverwriteRule\": \"name\",
      \"existAction\": \"update\"
    },
    \"data\": $(cat openapi.json)
  }")

echo "Apifox 响应：$RESPONSE"

if echo "$RESPONSE" | grep -q '"success":true'; then
  echo "同步成功！"
else
  echo "同步可能失败，请检查响应内容"
fi

