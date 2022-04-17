module.exports = {
  env: {
    browser: true,
    es2021: true,
  },
  plugins: [
    'eslint-plugin-html',
  ],
  extends: [
    'airbnb-base',
    'prettier',
  ],
  parserOptions: {
    ecmaVersion: 'latest',
  },
  rules: {
  },
};
