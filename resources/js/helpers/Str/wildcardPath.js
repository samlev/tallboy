import escapeRegex from "./escapeRegex";

export default (str, start = '^', end = '$') => {
  let body = (str ?? '');

  if (body.startsWith('*.')) {
    start = `${start}[a-zA-Z0-9-_]+`;
    body = body.slice(1);
  }

  if (body.endsWith('.*')) {
    end = `[a-zA-Z0-9-_\.]+${end}`
    body = body.slice(0, -1);
  }

  body = body.split('.*.')
    .map(escapeRegex)
    .join('\.[a-zA-Z0-9-_]+\.');

  return start + body + end
}
