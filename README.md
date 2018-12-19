# PHP E-Shop

## 09 - REST API

Run server with this command:

`php -S localhost:8080 server.php`

### GET /products

Returns list of all products

```text
curl -D - localhost:8080/products
HTTP/1.1 200 OK
Host: localhost:8080
Date: Sat, 15 Dec 2018 14:05:03 +0000
Connection: close
X-Powered-By: PHP/7.1.19
Content-Type: application/json;charset=utf-8
Content-Length: 160

[{"id":1,"name":"Penezenka","price":500,"vatRate":0.21},{"id":2,"name":"Mobil","price":15000,"vatRate":0.21},{"id":3,"name":"Klice","price":100,"vatRate":0.21}]
```

### GET /products/{id}

Returns object of given id

#### Found

```text
curl -D - localhost:8080/products/1
HTTP/1.1 200 OK
Host: localhost:8080
Date: Sat, 15 Dec 2018 14:11:28 +0000
Connection: close
X-Powered-By: PHP/7.1.19
Content-Type: application/json;charset=utf-8
Content-Length: 54

{"id":1,"name":"Penezenka","price":500,"vatRate":0.21}
```

#### Not found

```text
curl -D - localhost:8080/products/10
HTTP/1.1 404 Not Found
Host: localhost:8080
Date: Sat, 15 Dec 2018 14:12:51 +0000
Connection: close
X-Powered-By: PHP/7.1.19
Content-Type: application/json;charset=utf-8
Content-Length: 2

[]
```

### POST /customers

Creates a new customer

#### Valid request

```text
curl -D - --header "Content-Type: application/json" --data '{"name":"xyz","username":"xyz","password":
"xyz"}' http://localhost:8080/customers
HTTP/1.1 201 Created
Host: localhost:8080
Date: Sat, 15 Dec 2018 14:08:12 +0000
Connection: close
X-Powered-By: PHP/7.1.19
Content-type: application/json
Content-Length: 0
```

#### Invalid request

```text
curl -D - --header "Content-Type: application/json" --data '{"name":"xyz"}' http://localhost:8080/cust
omers
HTTP/1.1 400 Bad Request
Host: localhost:8080
Date: Sat, 15 Dec 2018 14:08:42 +0000
Connection: close
X-Powered-By: PHP/7.1.19
Content-Type: application/json;charset=utf-8
Content-Length: 62

{"errors":["Missing field username","Missing field password"]}
```

### GET /customer/current

Returns customer if authorized

#### Valid customer

```text
curl -D - -H "Authorization: Basic a25vdmFrOnBhc3N3b3Jka" -H "Content-Type: application/json" localhost:8080/customer/current
HTTP/1.1 200 OK
Host: localhost:8080
Date: Sat, 15 Dec 2018 14:01:18 +0000
Connection: close
X-Powered-By: PHP/7.1.19
Content-Type: application/json;charset=utf-8
Content-Length: 42

{"name":"Karel Novak","username":"knovak"}
```

#### Invalid customer

```text
curl -D - -H "Authorization: Basic a25vdmFrOnBhc33b3Jka" -H "Content-Type: application/json" localhost:8080/customer/current
HTTP/1.1 401 Unauthorized
Host: localhost:8080
Date: Sat, 15 Dec 2018 14:02:10 +0000
Connection: close
X-Powered-By: PHP/7.1.19
Content-Type: text/html; charset=UTF-8
Content-Length: 0
```

```text
curl -D - localhost:8080/customer/current
HTTP/1.1 401 Unauthorized
Host: localhost:8080
Date: Sat, 15 Dec 2018 14:03:34 +0000
Connection: close
X-Powered-By: PHP/7.1.19
Content-Type: text/html; charset=UTF-8
Content-Length: 0
```