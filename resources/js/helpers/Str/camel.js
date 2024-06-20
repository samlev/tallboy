import ucfirst from "./ucfirst";

export default (str) => str.split(/[^a-z0-9]/ig)
  .map((val, idx) => idx > 0 ? ucfirst(val) : val)
  .join('')
