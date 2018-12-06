import React, {Component} from 'react';
import './login.css';

class Login extends Componat {
  render(){
    return (
      <div classNmae="row samll-up-2 medium-up-3 large-up 4">
        <div className="column">
          <h2>Login Page</h2>
          <label>Username</label>
          <input type="text" name="username" placeholder="username" />
          <label>Password</label>
          <input type="password" name="password" placeholder="password" />
          <input type="submit" value="Login" className="button"/> 
        </div>
      </div>
    );
  }
}

export default Login;
