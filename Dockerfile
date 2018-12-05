FROM node:11

RUN apt-get update && apt-get install -y nano

RUN npm install -g pm2

WORKDIR /var/www/enda.ie

COPY ["package.json", "package-lock.json", "./"]

RUN npm install

COPY . .

USER node

EXPOSE 8080

ENV NODE_ENV production

CMD ["pm2", "start", "--no-daemon", "index.js"]
