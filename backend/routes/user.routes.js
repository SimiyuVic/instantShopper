import express from "express";
import { registerUser, userLogin } from "../controllers/user.controller.js";

const router = express();

//register user
router.post("/sign-up", registerUser);

//login controller
router.post("/login", userLogin);

export default router;