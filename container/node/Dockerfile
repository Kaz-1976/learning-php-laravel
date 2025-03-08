FROM node:22-alpine
EXPOSE 5173
RUN apk update && apk add --update nodejs npm && apk add git
RUN cd /workspace && npm install
WORKDIR /workspace
