import express from "express";
import { adminLogin, createCategory, createProduct } from "../controllers/admin.controller.js";

const router = express();

//login controller
router.post("/login", adminLogin);

//create products
router.post("/create-product", createProduct);

//create category
router.post("/create-category", createCategory);
export default router;