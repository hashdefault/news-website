# Portal de notícias 📰

[![Vue.js](https://img.shields.io/badge/-Vue.js-4FC08D?logo=vue.js&logoColor=white)](https://vuejs.org/)
[![PHP](https://img.shields.io/badge/PHP-%23777BB4?style=flat&logo=php&logoColor=white)](https://www.php.net/)
[![AWS](https://img.shields.io/badge/AWS-%23FF9900?style=flat&logo=amazon-aws&logoColor=white)](https://aws.amazon.com/)
[![EC2](https://img.shields.io/badge/Amazon%20EC2-%23FF9900?style=flat&logo=amazon-aws&logoColor=white)](https://aws.amazon.com/ec2/)
[![S3](https://img.shields.io/badge/Amazon%20S3-%23FF9900?style=flat&logo=amazon-s3&logoColor=white)](https://aws.amazon.com/s3/)
[![CloudFront](https://img.shields.io/badge/Amazon%20CloudFront-%23FF9900?style=flat&logo=amazon-aws&logoColor=white)](https://aws.amazon.com/cloudfront/)
[![Route 53](https://img.shields.io/badge/Amazon%20Route%2053-%23FF9900?style=flat&logo=amazon-aws&logoColor=white)](https://aws.amazon.com/route53/)
[![JSON API](https://img.shields.io/badge/JSON%20API-%23000000?style=flat&logo=json&logoColor=white)](https://jsonapi.org/)
[![Ubuntu](https://img.shields.io/badge/Ubuntu-%23E95420?style=flat&logo=ubuntu&logoColor=white)](https://ubuntu.com/)
[![NGINX](https://img.shields.io/badge/NGINX-%23009639?style=flat&logo=nginx&logoColor=white)](https://www.nginx.com/)
[![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)


Este é um simples exemplo de um site de notícias com Json API integrada para busca de novas/últimas notícias.
Contém com um canal ao vivo 24hrs (canal: abc news)

Tecnologias:
- API: [newsdata.io](https://newsdata.io/)
- Vue.Js 
- PHP
- Nginx
- AWS EC2 (S.O. Ubuntu)
- AWS S3 Bucket
- AWS Cloudfront
- AWS Route 53


## Screenshot
![image](https://github.com/user-attachments/assets/c82752a8-ef53-4b8f-9a45-2e94af1bebce)





## Como utilizar
1. Você vai precisar de uma API KEY gerada no site da [API](https://newsdata.io/) pode ser gerada gratuitamente

2. Configure o arquivo php-backend/.env
```
API_KEY=sua_api_key1234abcd
```

3. Configure o arquivo vue-frontend/.env
```
API_URL=http://localhost:8000
```

4. No arquivo get-news.php você vai precisar colocar a mesma url acima (http://localhost:8000)


5. Instale PHP 
```
$ sudo apt install php #ubuntu e derivados

#ou

$ sudo pacman install php #arch e derivados
```

6. Inicie o servidor do PHP
```
$ cd caminho/para/projeto/php-backend

$ php -S localhost:8000
```

7. Inicie o VueJS para frontend
```
$ cd caminho/para/projeto/vue-frontend

$ npm install

$ npm run dev
```

8. O projeto já deve estar rodando na porta onde VueJS exibiu para você! 🚀🚀🚀
- http://localhost:5173/

