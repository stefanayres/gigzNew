import React, { Component } from 'react';
import AuthService from './AuthService';

function withAuth(AuthComponent) {

const Auth = new AuthService(`http://127.0.0.1:8000/api`);

return class AuthWrapped extends Component {

        constructor() {
              super();
              this.state = {
                  user: null
              }
          }

        componentWillMount() {
        if (!Auth.loggedIn()) {
            this.props.history.replace('/Login')
        }
        else {
            try {
              const test = this.props;
                const profile = Auth.getProfile()
                this.setState({
                    user: profile
                })
            }
            catch(err){
                Auth.logout()
                this.props.history.replace('/Login')
            }
        }
    }

        render() {
            if (this.state.user) {
                return (
                    <AuthComponent history={this.props.history} user={this.state.user} />
                )
            }
            else {
                return null
            }
        }


    }
}

export default withAuth;