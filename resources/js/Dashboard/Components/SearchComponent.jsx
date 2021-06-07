import {useState, useEffect, useRef} from 'react';
import {Inertia} from "@inertiajs/inertia";

const SearchComponent = ({originalData, queries}) => {
    const [text, setText] = useState(queries?.s || '');
    const searchInput = useRef()

    useEffect(() => {
        if (queries.s) {
            searchInput.current.focus();
        }
    }, [])

    const handleChange = (e) => {
        let value = e.target.value
        setText(value)
        Inertia.get(originalData.path, {s: value})
    }

    return (
        <div>
            <input
                ref={searchInput}
                className={'form-control'}
                type="text"
                value={text}
                onChange={handleChange}
                placeholder={'search...'}
            />
        </div>
    );
}

export default SearchComponent;
