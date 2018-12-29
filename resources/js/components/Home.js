import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import AuthService from './AuthService';
import withAuth from './withAuth';

 class Home extends Component {
   constructor(){
       super();
       this.Auth = new AuthService();

   }
    render() {
      const test = this.props;
        return (
          <div>

            <div className="App">
            <div className="App-header">
              <h2>Welcome {this.props.user.username}</h2>
            </div>
            <p className="App-intro">
              <button type="button" className="form-submit" onClick={this.handleLogout.bind(this)}>Logout</button>
            </p>
            </div>

          </div>
        );
    }

    handleLogout(){
       this.Auth.logout();
       this.props.history.replace('/login');
    }
}
export default withAuth(Home);
