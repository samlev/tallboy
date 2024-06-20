export default (str) => str.replaceAll(/([^a-z0-9_]+)/g, '_$1')
  .toLowerCase()
  .replaceAll(/[^a-z0-9]+/g, '_');
