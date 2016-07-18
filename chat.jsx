var Comment = React.createClass({
    getInitialState: function (){
        return {editing: false}
    },
    edit: function(){
        this.setState({editing: true});
    },
    remove: function(){
        this.props.deleteFromDatas(this.props.index)
    },
    save: function(){
        this.props.updateCommentText(this.refs.newText.value, this.props.index);
        this.setState({editing: false});
    },
    renderNormally: function(){
            return (
                <div className="comment-container">
                    <div className="comment-text">{this.props.children}</div>
                    <button onClick={this.edit} className="button-edit">Edytuj</button>
                    <button onClick={this.remove} className="button-remove">Usuń</button>
                </div>
            )
    },
    renderEdit: function(){
        return(
            <div className="comment-container">
                <textarea ref="newText" defaultValue={this.props.children}></textarea>
                <button onClick={this.save} className="button-save">Zapisz</button>
            </div>
        );
    },
    render: function(){
        if(this.state.editing){
            return this.renderEdit();
        }else{
            return this.renderNormally();                        
        }
    }
});

var Datas = React.createClass({
    getInitialState: function(){
        return {
            comments: []
        }
    },
    add: function (text){
        var tab = this.state.comments;
        tab.push(text);
        this.setState({comments: tab})
    },
    removeComment: function(i){
        var tab = this.state.comments;
        tab.splice(i, 1);
        this.setState({comments:tab})
    },
    updateComment: function(newText, i){
        var tab = this.state.comments;
        tab[i] = newText;
        this.setState({comments: tab})
       
    },
  
    
    eachComment: function(text,i){
        return (
            <Comment key={i} index={i} updateCommentText={this.updateComment} deleteFromDatas={this.removeComment}>{text}</Comment>
        )
    },
    render : function (){
        return (
            <div>
                <button onClick={this.add.bind(null, 'Default text')} className = "button-create create">Dodaj</button>
                <div className="datas">
                    {this.state.comments.map(this.eachComment)}
                </div>
            
            </div>
        )}
       
    
});

ReactDOM.render(<Datas/>,document.getElementById('chat'));
















