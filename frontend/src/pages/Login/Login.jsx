const Login = () => {
    return (
        <div className="container mt-5">
            <div className="shadow-lg">
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
                            Sign In
                        </h3>
                        <p className="text-center text-muted">
                            Unlock a new whole world!
                        </p>

                        <div className="form-floating mb-5">
                            <input
                                type="email"
                                className="form-control"
                                id="floatingInput"
                                placeholder="johndoe@mail.com"
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
                            />
                            <label htmlFor="floatingPassword">
                                Password
                            </label>
                        </div>

                        <button className="btn btn-outline-primary fw-bold w-100 mb-4">
                            Sign In
                        </button>

                        <button className="btn btn-warning fw-bold  w-100 ">
                            Create an Account
                        </button>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default Login;