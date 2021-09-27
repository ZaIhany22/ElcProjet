import logo from './logo.svg';
import './App.css';
import axios from 'axios';

function App() {
  function fonct(){
    const data="" ;
    axios.get('http://localhost:8000/api/test',data).then(console.log(data)) ;
  }
  return (
    <div className="App">
     <button onClick={fonct}>mety</button> 
    </div>
  );
}

export default App;
