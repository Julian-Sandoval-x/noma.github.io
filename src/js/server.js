// import express from "express";
// import path from "path";
// import { fileURLToPath } from "url";
// const { static: serveStatic } = express;
// const app = express();
// import { execFile } from "child_process";
// const port = process.env.PORT || 8080; // Utiliza el puerto de Railway o el puerto 8080 por defecto

// // Obtener la ruta del directorio actual
// const __filename = fileURLToPath(import.meta.url);
// const __dirname = path.dirname(__filename);

// app.use(express.static(path.join(__dirname, "../.."))); // '..' sube un nivel a la raíz

// app.all("*.php", (req, res) => {
//   const phpScript = path.join(__dirname, "..", req.path);

//   console.log("Ejecutando PHP:", phpScript); // Log para verificar la ruta del archivo PHP

//   execFile("php-cgi", [phpScript], (error, stdout, stderr) => {
//     if (error) {
//       console.error(`execFile error: ${error}`);
//       res.status(500).send("Error ejecutando PHP");
//       return;
//     }
//     if (stderr) {
//       console.error(`stderr: ${stderr}`);
//       res.status(500).send("Error en la ejecución de PHP");
//       return;
//     }
//     res.setHeader("Content-Type", "text/html");
//     res.send(stdout); // Enviar la salida de PHP al navegador
//   });
// });

// // Ruta de ejemplo
// app.get("/", (req, res) => {
//   res.sendFile(path.join(__dirname, "..", "index.html"));
// });

// // Escucha en el puerto definido por Railway o en el 8080 por defecto
// app.listen(port, () => {
//   console.log(`Servidor escuchando en el puerto ${port}`);
// });
