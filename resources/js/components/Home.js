import React, { Component } from 'react';
import ReactDOM from 'react-dom';

import AuthService from './AuthService';
import withAuth from './withAuth';
const Auth = new AuthService();



 class Home extends Component {

    render() {
        return (
          <div>

            <div className="App">
            <div className="App-header">
            <h2>Welcome {this.props.user.email}</h2>
              </div>
            <p className="App-intro">
            <button type="button" className="form-submit" onClick={this.handleLogout.bind(this)}>Logout</button>
            </p>
            </div>

          </div>
        );
    }
}
export default withAuth(Home);
