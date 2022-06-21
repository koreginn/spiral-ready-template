<p align="center"><a href="http://thenoco.co/" target="_blank"><img src="https://s3.eu-west-1.amazonaws.com/no.images/logo_+release.png" width="150"></a></p>

## About Server

You can read the documentation and API description in the WIKI section on Github.

We will be happy to review all bugs and bugs of the platform.


> Documentation is available at the link `https://service.api.thenoco.co/public/documentation`.

Launch a project for development:

```$xslt
$ docker-compose up -d
```

Launch a project for production:

```$xslt
$ docker-compose up -d -e RR_WORKERS=1 -e RR_MAX_JOBS=1
```

Application will be available on `http:/31.184.215.238:8000`.
