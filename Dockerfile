FROM node:14-alpine as builder

COPY ["package.json", "yarn.lock", "./"]

RUN yarn

FROM node:14-alpine

USER node

WORKDIR /usr/src/app

ENV NODE_ENV=production

COPY --from=builder node_modules node_modules

COPY . .

CMD ["node", "index.js"]
