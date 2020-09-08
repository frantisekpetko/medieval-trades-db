import React from 'react';
import ajax from '../utils/ajax';
import HeadHtml from '../HeadHtml';

class Page extends React.Component {
    state = {
        page: []
    };

    componentDidMount() {
        ajax.get('/page')
            .then(response => {
                const page = response.data;
                console.warn('Possible Exception', response.data);
                this.setState({ page: page });
                console.log(response.status);
            })
            .catch(error => {
                console.log(error);
            });
    }

    static createMarkup(markup) {
        return { __html: markup };
    }

    render() {
        let id = 'name';
        console.log('page', /*this.state.page[0]["name"]*/ null);

        return (
            <div>
                <HeadHtml pageTitle="Page" />
                <div>
                    Page:
                    <ul>
                        {this.state.page.map(p => (
                            <React.Fragment key={p.id}>
                                <li>{p.id}</li>
                                <li dangerouslySetInnerHTML={Page.createMarkup(p.content)} />
                                <hr />
                            </React.Fragment>
                        ))}
                    </ul>
                </div>
            </div>
        );
    }
}

export default Page;
