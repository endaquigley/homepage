FROM node:12-alpine as builder

RUN npm install -g yarn

COPY ["package.json", "yarn.lock", "./"]

RUN yarn

FROM node:12-alpine

RUN npm install -g pm2

USER node

EXPOSE 3000

WORKDIR /usr/src/app

ENV NODE_ENV=production

COPY --from=builder node_modules node_modules

COPY . .

CMD ["pm2-runtime", "index.js"]