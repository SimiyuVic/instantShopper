import User from "../models/user.model.js";
import jwt from "jsonwebtoken";
import bcrypt from "bcryptjs";
import validator from "validator";

//user registration
export const registerUser = async (req, res) => {
    try {
        const { userName, userEmail, userPassword, userRole } = req.body;

        // Form validation
        if (!userName || !userEmail || !userPassword) {
            return res.status(400).json({
                success: false,
                message: "All fields are required!"
            });
        }

        // Clean input
        const email = userEmail.trim().toLowerCase();
        const username = userName.trim();

        // Username validation
        if (username.length < 3) {
            return res.status(400).json({
                success: false,
                message: "Username must be at least 3 characters long!"
            });
        }

        // Email validationm
        if (!validator.isEmail(email)) {
            return res.status(400).json({
                success: false,
                message: "Please enter a valid email address!"
            });
        }

        // Password length validation
        if (userPassword.length < 8) {
            return res.status(400).json({
                success: false,
                message: "Password must be at least 8 characters long!"
            });
        }

        // Password strength validation
        if (
            !/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/.test(userPassword)
        ) {
            return res.status(400).json({
                success: false,
                message:
                    "Password must contain at least one uppercase letter, one lowercase letter, and one number!"
            });
        }

        // Check if user already exists
        const checkExistingUser = await User.findOne({
            $or: [
                { userEmail: email },
                { userName: username }
            ]
        });

        if (checkExistingUser) {
            return res.status(409).json({
                success: false,
                message: "User already exists!"
            });
        }

        // Hash password
        const hashedPassword = await bcrypt.hash(userPassword, 10);

        // Create user
        const newUser = new User({
            userName: username,
            userEmail: email,
            userPassword: hashedPassword,
            userRole
        });

        await newUser.save();

        return res.status(201).json({
            success: true,
            message: `User ${username} created successfully!`
        });

    } catch (error) {
        console.error(error);

        return res.status(500).json({
            success: false,
            message: "Something went wrong while registering!"
        });
    }
};

//user login
export const userLogin = async (req, res) => {
    try {
        const { userEmail, userPassword } = req.body;

        // Form validation
        if (!userEmail || !userPassword) {
            return res.status(400).json({
                success: false,
                message: "All fields are required!"
            });
        }

        // Check user
        const user = await User.findOne({ userEmail })
            .select("+userPassword");

        if (!user) {
            return res.status(401).json({
                success: false,
                message: "Invalid Credentials"
            });
        }

        // Compare password
        const passwordMatch = await bcrypt.compare(
            userPassword,
            user.userPassword
        );

        if (!passwordMatch) {
            return res.status(401).json({
                success: false,
                message: "Invalid Credentials"
            });
        }

        // Create token
        const token = jwt.sign(
            {
                id: user._id,
                userRole: user.userRole
            },
            process.env.JWT_SECRET_KEY,
            {
                expiresIn: "2d"
            }
        );

        // Create cookie
        res.cookie("instantShopper", token, {
            httpOnly: true,
            secure: true,
            sameSite: "None",
            maxAge: 2 * 24 * 60 * 60 * 1000, // 2 days
            path: "/"
        });

        return res.status(200).json({
            success: true,
            message: `Welcome ${user.userName}`,
            token
        });

    } catch (error) {
        console.error(error);

        return res.status(500).json({
            success: false,
            message: "Something went wrong while logging in!"
        });
    }
};
