import React, { Component } from 'react';
import logo from './logo.svg';
import './App.css';


class App extends Component {

  Data;
  
  componentDidMount(){
    fetch('http://127.0.0.1:8000/api/test').then(function(response){
      response.json().then(function(resp){
        this.Data=resp; 
      })
    });
    
  }
  render() {
    return(
      <div className="App">
          {this.Data}
      </div>
    ) ;
  }

   
  
}

export default App;
