import express from "express";
import dotenv from "dotenv";
import { connectDB } from "./configuration/database.config.js";
import authRoutes from "./routes/user.routes.js";
import categoryRoutes from "./routes/category.routes.js";
import adminRoutes from "./routes/admin.routes.js";
import cors from "cors";

dotenv.config();
//create an instance of express
const app = express();

app.use(express.json());

app.use(cors({
    origin: [
        "http://localhost:5173"
    ],
    credentials: true,
}));

const PORT = process.env.PORT;

//user routes
app.use("/api/auth", authRoutes)

//admin routes
app.use("/api/admin", adminRoutes);

//category routes
app.use("/api/category", categoryRoutes);

const startServer = async()=>{
    app.listen(PORT, ()=>{
        console.log(`Server running on PORT ${PORT}`)
    });

    await connectDB();
}
startServer();