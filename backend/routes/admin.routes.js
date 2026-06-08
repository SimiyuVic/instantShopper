import express from "express";
import { adminLogin, createProduct } from "../controllers/admin.controller.js";

const router = express();

//login controller
router.post("/login", adminLogin);

//create products
router.post("/create-product", createProduct);

export default router;