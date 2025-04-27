const { exec } = require("child_process");
exec("php -S 0.0.0.0:$PORT", (error, stdout, stderr) => {
  if (error) {
    console.error(`Error: ${error}`);
    return;
  }
  console.log(`Output: ${stdout}`);
});
