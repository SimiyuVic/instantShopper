import { useState } from "react";

const SignUp = () => {

    const [userName, setUserName] = useState("");
    const [userEmail, setUserEmail] = useState("");
    const [userPassword, setUserPassword] = useState("");

    const handleRegister = async()=>{

    }

    return (
        <div className="container mt-5">
            <div className="shadow-lg">
                <form action="" onSubmit={handleRegister}>
                    <div className="row">
                        <div className="col-md-6">
                            <img
                                src="/authPages.jpg"
                                alt="Authentication"
                                className="img-fluid h-100 w-100"
                                style={{
                                    objectFit: "cover"
                                }}
                            />
                        </div>

                        <div className="col-md-5 p-5">
                            <h3 className="text-center text-muted mb-4">
                                Sign Up
                            </h3>
                            <p className="text-center text-muted">
                                We have more than enough waiting !
                            </p>

                            <div className="form-floating mb-5">
                                <input
                                    type="text"
                                    className="form-control"
                                    id="floatingInput"
                                    placeholder="John Doe"
                                    value={userName}
                                    onChange={(e)=>setUserName(e.target.value)}
                                />
                                <label htmlFor="floatingInput">
                                    User Name
                                </label>
                            </div>

                            <div className="form-floating mb-5">
                                <input
                                    type="email"
                                    className="form-control"
                                    id="floatingInput"
                                    placeholder="johndoe@mail.com"
                                    value={userEmail}
                                    onChange={(e)=>setUserEmail(e.target.value)}
                                />
                                <label htmlFor="floatingInput">
                                    Email address
                                </label>
                            </div>

                            <div className="form-floating mb-5">
                                <input
                                    type="password"
                                    className="form-control"
                                    id="floatingPassword"
                                    placeholder="Password"
                                    value={userPassword}
                                    onChange={(e)=>setUserPassword(e.target.value)}
                                />
                                <label htmlFor="floatingPassword">
                                    Password
                                </label>
                            </div>

                            <button className="btn btn-outline-primary fw-bold w-100 mb-4">
                                Create Account
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    );
};

export default SignUp;