import express from "express";
import { fetchAllProducts } from "../controllers/products.controller.js";

const router = express();

//fetch all products
router.get("all-products", fetchAllProducts);

//fetch recent products

//fetch on offer products

export default router;