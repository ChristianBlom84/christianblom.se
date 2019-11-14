FROM mhart/alpine-node:latest as app-builder

ADD package-lock.json /package-lock.json
ADD package.json /package.json

ENV NODE_PATH=/node_modules
ENV PATH=$PATH:/node_modules/.bin

WORKDIR /app
COPY . /app

RUN npm install

RUN npm run build

FROM nginx:stable-alpine

COPY --from=app-builder /app /usr/share/nginx/html

EXPOSE 80

CMD ["nginx", "-g", "daemon off;"]
