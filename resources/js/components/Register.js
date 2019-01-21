import React, {Component} from 'react';
require('../bootstrap');
import AuthService from './AuthService';

class Register extends Component {

    constructor(){
        super();
        this.handleChange = this.handleChange.bind(this);
        this.handleFormSubmit = this.handleFormSubmit.bind(this);
        this.Auth = new AuthService();
    }

    register(username, email, password, role) {
        // Get a token from api server using the fetch api
        return this.fetch(`${this.domain}/register`, {
            method: 'POST',
            body: JSON.stringify({
                username,
                email,
                password,
                role
            })
        }).then(res => {
            this.setToken(res.token) // Setting the token in localStorage
            return Promise.resolve(res);
        })
    }

    handleFormSubmit(e){
        e.preventDefault();

        this.Auth.register(this.state.username,this.state.email,this.state.password, this.state.role)
            .then(res =>{
               this.props.history.replace('/');
            })
            .catch(err =>{
                alert(err);
            })
    }

    componentWillMount(){
    if(this.Auth.loggedIn())
        this.props.history.replace('/');
      }

      handleChange(e){
          this.setState(
              {
                  [e.target.name]: e.target.value
              }
          )
          console.log(e.target.value); //test
      }

  handle(event) {
    console.log(event.target.value);
    this.setState({
      ...this.state,
      selectedValue: event.target.value
    });
  };


    render() {
        return (
            <div className="center">
                <div className="card">
                    <h1>Login</h1>
                    <form>
                        <input
                            className="form-item"
                            placeholder="Username goes here..."
                            name="username"
                            type="text"
                            onChange={this.handleChange}
                        />
                        <input
                            className="form-item"
                            placeholder="Email goes here..."
                            name="email"
                            type="text"
                            onChange={this.handleChange}
                        />
                        <input
                            className="form-item"
                            placeholder="Password goes here..."
                            name="password"
                            type="password"
                            onChange={this.handleChange}
                        />
                        <div className="btn-group" data-toggle="buttons">
                          <label className="btn btn-secondary active">
                          <input
                            type="radio"
                            name="options"
                            value="0"
                            defaultChecked
                            onChange={this.handle} /> Band
                        </label>
                          <label className="btn btn-secondary">
                          <input
                            type="radio"
                            name="options"
                            value="1"
                            onChange={this.handle } /> Venue
                      </label>
                      </div>
                      <input
                          className="form-submit"
                          value="SUBMIT"
                          type="submit"
                          onClick={this.handleFormSubmit}
                      />
                    </form>
                </div>
            </div>
        );
    }

}

export default Register;
