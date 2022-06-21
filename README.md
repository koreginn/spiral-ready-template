Launch a project for development:

```$xslt
$ docker-compose up -d
```

Launch a project for production:

```$xslt
$ docker-compose up -d -e RR_WORKERS=1 -e RR_MAX_JOBS=1
```
