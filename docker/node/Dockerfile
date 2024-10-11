FROM node:22-alpine as node
EXPOSE 5173

RUN apk update && apk add --update nodejs npm && apk add git

WORKDIR /work