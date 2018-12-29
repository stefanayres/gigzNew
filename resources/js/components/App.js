import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import {BrowserRouter, Route, Switch} from 'react-router-dom';


import Home from './Home';
import About from './About';
import Login from './Login';
import Error from './Error';
import Nav from './Nav';

class App extends Component {

    constructor(){
        super();
    }


    render() {
        return (
          <BrowserRouter>
          <div>
            <Nav />
              <Switch>
                <Route path='/' exact component={Home} />
                <Route path='/About' component={About} />
                <Route path='/Login' component={Login} />
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
