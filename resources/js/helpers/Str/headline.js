import snake from "./snake";
import ucfirst from "./ucfirst";

export default (str) => snake(str)
  .split('_')
  .map(part => ucfirst(part))
  .join(' ')
