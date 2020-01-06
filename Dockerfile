FROM node:12-alpine as builder

COPY ["package.json", "yarn.lock", "./"]

RUN yarn

FROM node:12-alpine

USER node

EXPOSE 3000

WORKDIR /usr/src/app

ENV NODE_ENV=production

COPY --from=builder node_modules node_modules

COPY . .

CMD ["node", "index.js"]