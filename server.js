const { exec } = require("child_process");
const port = process.env.PORT || 3000;

exec(`php -S 0.0.0.0:${port} -t public`, (error, stdout, stderr) => {
  console.log(stdout);
  console.error(stderr);
  if (error) process.exit(1);
});
