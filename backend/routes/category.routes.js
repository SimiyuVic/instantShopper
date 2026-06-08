import express from "express";

const router = express();

//create category
router.post("/create-category", createCategory);

export default router;