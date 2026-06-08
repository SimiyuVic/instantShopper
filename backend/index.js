import express from "express";
import dotenv from "dotenv";
import { connectDB } from "./configuration/database.config.js";
import authRoutes from "./routes/user.routes.js";

dotenv.config();
//create an instance of express
const app = express();

app.use(express.json());

const PORT = process.env.PORT;

app.use("/api/auth", authRoutes)

const startServer = async()=>{
    app.listen(PORT, ()=>{
        console.log(`Server running on PORT ${PORT}`)
    });

    await connectDB();
}
startServer();