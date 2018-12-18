import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter, Route, Switch} from 'react-router-dom';

import Home from './Home';
import About from './About';
import Login from './Login';
import Error from './Error';
import Nav from './Nav';


class App extends Component {

  handleLogout(){
   Auth.logout()
   this.props.history.replace('/login');
}

    render() {
        return (
          <BrowserRouter>
          <div>
            <Nav />
              <Switch>
                <Route path='/' exact component={Home} />
                <Route path='/About' component={About} />
                //<Route path='/Login' component={Login} />
                <Route exact path='/Login' render={(props) => <Login />} />

                <Route component={Error} />
              </Switch>
            </div>
          </BrowserRouter>

        );
    }
}

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}
